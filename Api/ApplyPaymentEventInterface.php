<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api;

interface ApplyPaymentEventInterface
{
    /**
     * @param string $orderId
     * @param string $paymentEventId
     * @param string $paymentSessionId
     * @param string $normalizedStatus
     * @param string|null $occurredAt
     * @param array<string, mixed>|null $payload
     * @return array<string, mixed>
     */
    public function execute(
        string $orderId,
        string $paymentEventId,
        string $paymentSessionId,
        string $normalizedStatus,
        ?string $occurredAt = null,
        ?array $payload = null
    ): array;
}
