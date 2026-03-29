<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api;

use SeoulCommerce\KoreaCheckoutAdapter\Api\Data\ApplyPaymentEventResponseInterface;

interface ApplyPaymentEventInterface
{
    /**
     * @param string $orderId
     * @param string $paymentEventId
     * @param string $paymentSessionId
     * @param string $normalizedStatus
     * @param string|null $occurredAt
     * @param string|null $gatewayTransactionRef
     * @return \SeoulCommerce\KoreaCheckoutAdapter\Api\Data\ApplyPaymentEventResponseInterface
     */
    public function execute(
        string $orderId,
        string $paymentEventId,
        string $paymentSessionId,
        string $normalizedStatus,
        ?string $occurredAt = null,
        ?string $gatewayTransactionRef = null
    ): ApplyPaymentEventResponseInterface;
}
