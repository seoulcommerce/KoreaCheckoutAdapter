<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Service;

use Magento\Customer\Api\Data\GroupInterface;
use Magento\Framework\Exception\InputException;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\GuestCartManagementInterface;
use Magento\Quote\Api\PaymentMethodManagementInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use SeoulCommerce\KoreaCheckoutAdapter\Api\CreatePendingOrderInterface;
use SeoulCommerce\KoreaCheckoutAdapter\Api\Data\CreatePendingOrderResponseInterface;
use SeoulCommerce\KoreaCheckoutAdapter\Model\Data\CreatePendingOrderResponseFactory;

class CreatePendingOrderService implements CreatePendingOrderInterface
{
    public function __construct(
        private readonly QuoteIdMaskFactory $quoteIdMaskFactory,
        private readonly CartRepositoryInterface $cartRepository,
        private readonly CartManagementInterface $cartManagement,
        private readonly GuestCartManagementInterface $guestCartManagement,
        private readonly PaymentMethodManagementInterface $paymentMethodManagement,
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly CreatePendingOrderResponseFactory $responseFactory
    ) {
    }

    public function execute(
        string $merchantId,
        string $storeId,
        string $cartId,
        string $gateway,
        string $paymentMethod,
        ?string $customerEmail,
        string $idempotencyKey
    ): CreatePendingOrderResponseInterface {
        unset($merchantId, $storeId, $idempotencyKey);

        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        $quoteId = (int) $quoteIdMask->getQuoteId();

        if (!$quoteId) {
            throw new LocalizedException(new Phrase('Masked cart id could not be resolved.'));
        }

        $quote = $this->cartRepository->get($quoteId);
        $this->validateQuote($quote, $customerEmail);
        $this->prepareGuestQuote($quote, $customerEmail);

        $resolvedPaymentMethod = $this->resolvePaymentMethodCode($quoteId, $quote, $gateway, $paymentMethod);
        $quote->getPayment()->importData(['method' => $resolvedPaymentMethod]);
        $quote->setTotalsCollectedFlag(false);
        $quote->collectTotals();
        $this->cartRepository->save($quote);

        try {
            $orderId = (int) (
                $quote->getCustomerId()
                    ? $this->cartManagement->placeOrder($quoteId)
                    : $this->guestCartManagement->placeOrder($cartId)
            );
        } catch (\Throwable $e) {
            throw new LocalizedException(
                new Phrase(
                    'Order placement failed for masked cart %1 using payment method %2: %3',
                    [$cartId, $resolvedPaymentMethod, $e->getMessage()]
                ),
                $e
            );
        }

        $order = $this->orderRepository->get($orderId);

        return $this->responseFactory->create()
            ->setPlatformType('magento')
            ->setOrderId((string) $order->getEntityId())
            ->setOrderNumber((string) $order->getIncrementId())
            ->setState((string) $order->getState())
            ->setStatus((string) $order->getStatus());
    }

    private function validateQuote(CartInterface $quote, ?string $customerEmail): void
    {
        if (!$quote->getItemsCount()) {
            throw new InputException(new Phrase('Quote is empty and cannot be converted into an order.'));
        }

        if (!$quote->isVirtual()) {
            $shippingAddress = $quote->getShippingAddress();

            if (!$shippingAddress || !$shippingAddress->getCountryId()) {
                throw new InputException(new Phrase('Quote is missing a shipping address.'));
            }

            if (!$shippingAddress->getShippingMethod()) {
                throw new InputException(new Phrase('Quote is missing a shipping method.'));
            }
        }

        if (!$quote->getBillingAddress() || !$quote->getBillingAddress()->getCountryId()) {
            throw new InputException(new Phrase('Quote is missing a billing address.'));
        }

        if (!$quote->getCustomerId() && !$quote->getCustomerEmail() && !$customerEmail) {
            throw new InputException(new Phrase('Guest quote is missing a customer email.'));
        }
    }

    private function prepareGuestQuote(CartInterface $quote, ?string $customerEmail): void
    {
        if ($quote->getCustomerId()) {
            return;
        }

        $email = $customerEmail ?: (string) $quote->getCustomerEmail();
        $quote->setCustomerEmail($email);
        $quote->setCustomerIsGuest(true);
        $quote->setCustomerGroupId(GroupInterface::NOT_LOGGED_IN_ID);
        $quote->setCheckoutMethod('guest');
    }

    private function resolvePaymentMethodCode(
        int $quoteId,
        CartInterface $quote,
        string $gateway,
        string $paymentMethod
    ): string {
        $availableMethods = $this->paymentMethodManagement->getList($quoteId);
        $availableCodes = array_values(array_filter(array_map(
            static fn ($method): string => (string) $method->getCode(),
            $availableMethods
        )));

        $candidates = array_values(array_unique(array_filter([
            (string) $quote->getPayment()->getMethod(),
            $paymentMethod,
            $gateway,
        ])));

        foreach ($candidates as $candidate) {
            if (in_array($candidate, $availableCodes, true)) {
                return $candidate;
            }
        }

        throw new InputException(
            new Phrase(
                'No valid Magento payment method could be resolved. Requested candidates: %1. Available methods: %2',
                [implode(', ', $candidates), implode(', ', $availableCodes)]
            )
        );
    }
}
