<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Service;

use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use SeoulCommerce\KoreaCheckoutAdapter\Api\CreatePendingOrderInterface;

class CreatePendingOrderService implements CreatePendingOrderInterface
{
    public function __construct(
        private readonly QuoteIdMaskFactory $quoteIdMaskFactory,
        private readonly CartManagementInterface $cartManagement,
        private readonly OrderRepositoryInterface $orderRepository
    ) {
    }

    public function execute(
        string $merchantId,
        string $storeId,
        string $cartId,
        array $paymentSelection,
        ?array $customer,
        string $idempotencyKey
    ): array {
        unset($merchantId, $storeId, $paymentSelection, $customer, $idempotencyKey);

        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        $quoteId = (int) $quoteIdMask->getQuoteId();

        if (!$quoteId) {
            throw new LocalizedException(new Phrase('Masked cart id could not be resolved.'));
        }

        /**
         * v1 note:
         * - idempotency key handling still needs a dedicated adapter-side store or quote/order lookup strategy
         * - payment selection is expected to have already been applied to the quote before placement
         */
        $orderId = (int) $this->cartManagement->placeOrder($quoteId);
        $order = $this->orderRepository->get($orderId);

        return [
            'platformType' => 'magento',
            'orderId' => (string) $order->getEntityId(),
            'orderNumber' => (string) $order->getIncrementId(),
            'state' => (string) $order->getState(),
            'status' => (string) $order->getStatus(),
        ];
    }
}
