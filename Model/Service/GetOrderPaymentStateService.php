<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Service;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use SeoulCommerce\KoreaCheckoutAdapter\Api\GetOrderPaymentStateInterface;

class GetOrderPaymentStateService implements GetOrderPaymentStateInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly BindingLookup $bindingLookup
    ) {
    }

    public function execute(string $orderId): array
    {
        $order = $this->orderRepository->get((int) $orderId);
        $binding = $this->bindingLookup->getByOrderId((int) $order->getEntityId());
        $payment = $order->getPayment();

        if (!$payment) {
            throw new LocalizedException(new Phrase('Order payment could not be loaded.'));
        }

        return [
            'orderId' => (string) $order->getEntityId(),
            'orderNumber' => (string) $order->getIncrementId(),
            'state' => (string) $order->getState(),
            'status' => (string) $order->getStatus(),
            'paymentSessionId' => $binding ? (string) $binding->getData('payment_session_id') : null,
            'lastPaymentEventId' => $binding ? (string) $binding->getData('platform_event_id_last_applied') : null,
            'lastNormalizedStatus' => $binding ? (string) $binding->getData('last_normalized_status') : null,
            'paymentMethod' => (string) $payment->getMethod(),
        ];
    }
}
