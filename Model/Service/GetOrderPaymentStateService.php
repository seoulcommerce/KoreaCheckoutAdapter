<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Service;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use SeoulCommerce\KoreaCheckoutAdapter\Api\GetOrderPaymentStateInterface;
use SeoulCommerce\KoreaCheckoutAdapter\Api\Data\OrderPaymentStateInterface;
use SeoulCommerce\KoreaCheckoutAdapter\Model\Data\OrderPaymentStateFactory;

class GetOrderPaymentStateService implements GetOrderPaymentStateInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly BindingLookup $bindingLookup,
        private readonly OrderPaymentStateFactory $orderPaymentStateFactory
    ) {
    }

    public function execute(string $orderId): OrderPaymentStateInterface
    {
        $order = $this->orderRepository->get((int) $orderId);
        $binding = $this->bindingLookup->getByOrderId((int) $order->getEntityId());
        $payment = $order->getPayment();

        if (!$payment) {
            throw new LocalizedException(new Phrase('Order payment could not be loaded.'));
        }

        $paymentSessionId = null;
        $lastPaymentEventId = null;
        $lastNormalizedStatus = null;

        if ($binding) {
            $bindingPaymentSessionId = $binding->getData('payment_session_id');
            $bindingLastPaymentEventId = $binding->getData('platform_event_id_last_applied');
            $bindingLastNormalizedStatus = $binding->getData('last_normalized_status');

            $paymentSessionId = $bindingPaymentSessionId === null ? null : (string) $bindingPaymentSessionId;
            $lastPaymentEventId = $bindingLastPaymentEventId === null ? null : (string) $bindingLastPaymentEventId;
            $lastNormalizedStatus = $bindingLastNormalizedStatus === null ? null : (string) $bindingLastNormalizedStatus;
        }

        return $this->orderPaymentStateFactory->create()
            ->setOrderId((string) $order->getEntityId())
            ->setOrderNumber((string) $order->getIncrementId())
            ->setState((string) $order->getState())
            ->setStatus((string) $order->getStatus())
            ->setPaymentSessionId($paymentSessionId)
            ->setLastPaymentEventId($lastPaymentEventId)
            ->setLastNormalizedStatus($lastNormalizedStatus);
    }
}
