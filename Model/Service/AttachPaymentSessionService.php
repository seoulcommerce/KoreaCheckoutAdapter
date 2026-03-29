<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Service;

use Magento\Sales\Api\OrderRepositoryInterface;
use SeoulCommerce\KoreaCheckoutAdapter\Model\BindingFactory;
use SeoulCommerce\KoreaCheckoutAdapter\Model\ResourceModel\Binding as BindingResource;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use SeoulCommerce\KoreaCheckoutAdapter\Api\AttachPaymentSessionInterface;
use SeoulCommerce\KoreaCheckoutAdapter\Api\Data\AttachPaymentSessionResponseInterface;
use SeoulCommerce\KoreaCheckoutAdapter\Model\Data\AttachPaymentSessionResponseFactory;

class AttachPaymentSessionService implements AttachPaymentSessionInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly BindingFactory $bindingFactory,
        private readonly BindingResource $bindingResource,
        private readonly BindingLookup $bindingLookup,
        private readonly PaymentMetadataWriter $paymentMetadataWriter,
        private readonly AttachPaymentSessionResponseFactory $responseFactory
    ) {
    }

    public function execute(string $orderId, string $paymentSessionId): AttachPaymentSessionResponseInterface
    {
        $order = $this->orderRepository->get((int) $orderId);
        $existingByOrder = $this->bindingLookup->getByOrderId((int) $order->getEntityId());

        if ($existingByOrder && $existingByOrder->getData('payment_session_id') !== $paymentSessionId) {
            throw new LocalizedException(
                new Phrase('Order already has a different paymentSessionId attached.')
            );
        }

        $existingBySession = $this->bindingLookup->getByPaymentSessionId($paymentSessionId);

        if ($existingBySession && (int) $existingBySession->getData('order_id') !== (int) $order->getEntityId()) {
            throw new LocalizedException(
                new Phrase('paymentSessionId is already bound to a different Magento order.')
            );
        }

        $binding = $existingByOrder ?: $this->bindingFactory->create();
        $binding->setData('order_id', (int) $order->getEntityId());
        $binding->setData('increment_id', (string) $order->getIncrementId());
        $binding->setData('payment_session_id', $paymentSessionId);
        $binding->setData('binding_status', 'attached');
        $binding->setData('last_normalized_status', $existingByOrder?->getData('last_normalized_status') ?: 'ready');

        $this->bindingResource->save($binding);

        $this->paymentMetadataWriter->write($order, [
            'payment_session_id' => $paymentSessionId,
            'payment_orchestration_last_normalized_status' => $binding->getData('last_normalized_status'),
        ]);
        $this->orderRepository->save($order);

        return $this->responseFactory->create()
            ->setAttached(true)
            ->setOrderId((string) $order->getEntityId())
            ->setOrderNumber((string) $order->getIncrementId())
            ->setPaymentSessionId($paymentSessionId);
    }
}
