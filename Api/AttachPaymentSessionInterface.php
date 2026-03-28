<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api;

interface AttachPaymentSessionInterface
{
    /**
     * @param string $orderId
     * @param string $paymentSessionId
     * @return array<string, mixed>
     */
    public function execute(string $orderId, string $paymentSessionId): array;
}
