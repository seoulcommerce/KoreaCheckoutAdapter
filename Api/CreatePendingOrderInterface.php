<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api;

interface CreatePendingOrderInterface
{
    /**
     * @param string $merchantId
     * @param string $storeId
     * @param string $cartId
     * @param string $gateway
     * @param string $paymentMethod
     * @param string|null $customerEmail
     * @param string $idempotencyKey
     * @return array<string, mixed>
     */
    public function execute(
        string $merchantId,
        string $storeId,
        string $cartId,
        string $gateway,
        string $paymentMethod,
        ?string $customerEmail,
        string $idempotencyKey
    ): array;
}
