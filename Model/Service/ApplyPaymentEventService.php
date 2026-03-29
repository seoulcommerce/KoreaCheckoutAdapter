<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Service;

use Magento\Sales\Api\OrderRepositoryInterface;
use SeoulCommerce\KoreaCheckoutAdapter\Model\ResourceModel\Binding as BindingResource;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use SeoulCommerce\KoreaCheckoutAdapter\Api\ApplyPaymentEventInterface;
use SeoulCommerce\KoreaCheckoutAdapter\Api\Data\ApplyPaymentEventResponseInterface;
use SeoulCommerce\KoreaCheckoutAdapter\Model\Data\ApplyPaymentEventResponseFactory;

class ApplyPaymentEventService implements ApplyPaymentEventInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly BindingLookup $bindingLookup,
        private readonly BindingResource $bindingResource,
        private readonly StatusMapper $statusMapper,
        private readonly PaymentMetadataWriter $paymentMetadataWriter,
        private readonly InvoiceOrderService $invoiceOrderService,
        private readonly ApplyPaymentEventResponseFactory $responseFactory
    ) {
    }

    public function execute(
        string $orderId,
        string $paymentEventId,
        string $paymentSessionId,
        string $normalizedStatus,
        ?string $occurredAt = null,
        ?string $gatewayTransactionRef = null
    ): ApplyPaymentEventResponseInterface {
        $order = $this->orderRepository->get((int) $orderId);
        $binding = $this->bindingLookup->getByOrderId((int) $order->getEntityId());

        if (!$binding) {
            throw new LocalizedException(new Phrase('Order binding does not exist.'));
        }

        if ((string) $binding->getData('payment_session_id') !== $paymentSessionId) {
            throw new LocalizedException(new Phrase('paymentSessionId does not match existing order binding.'));
        }

        if ((string) $binding->getData('platform_event_id_last_applied') === $paymentEventId) {
            return $this->buildResult($order, $binding, false);
        }

        $mapped = $this->statusMapper->map(
            $normalizedStatus,
            (string) $order->getState(),
            (string) $order->getStatus()
        );

        $order->setState($mapped['state']);
        $order->setStatus($mapped['status']);

        $this->paymentMetadataWriter->write($order, [
            'payment_session_id' => $paymentSessionId,
            'payment_orchestration_last_event_id' => $paymentEventId,
            'payment_orchestration_last_normalized_status' => $normalizedStatus,
            'payment_orchestration_gateway_transaction_ref' => $gatewayTransactionRef,
        ]);

        $this->orderRepository->save($order);

        if ($normalizedStatus === 'paid') {
            $this->invoiceOrderService->execute($order);
        }

        $binding->setData('platform_event_id_last_applied', $paymentEventId);
        $binding->setData('last_normalized_status', $normalizedStatus);
        if ($gatewayTransactionRef !== null) {
            $binding->setData('last_gateway_transaction_ref', $gatewayTransactionRef);
        }
        $this->bindingResource->save($binding);

        return $this->buildResult($order, $binding, true);
    }

    private function buildResult(
        \Magento\Sales\Api\Data\OrderInterface $order,
        \SeoulCommerce\KoreaCheckoutAdapter\Model\Binding $binding,
        bool $applied
    ): ApplyPaymentEventResponseInterface {
        return $this->responseFactory->create()
            ->setApplied($applied)
            ->setOrderId((string) $order->getEntityId())
            ->setOrderNumber((string) $order->getIncrementId())
            ->setState((string) $order->getState())
            ->setStatus((string) $order->getStatus())
            ->setPaymentSessionId((string) $binding->getData('payment_session_id'))
            ->setLastPaymentEventId($binding->getData('platform_event_id_last_applied') !== null ? (string) $binding->getData('platform_event_id_last_applied') : null)
            ->setLastNormalizedStatus($binding->getData('last_normalized_status') !== null ? (string) $binding->getData('last_normalized_status') : null);
    }
}
