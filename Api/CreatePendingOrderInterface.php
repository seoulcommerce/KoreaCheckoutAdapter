<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api;

interface CreatePendingOrderInterface
{
    /**
     * @param string $merchantId
     * @param string $storeId
     * @param string $cartId
     * @param array<string, mixed> $paymentSelection
     * @param array<string, mixed>|null $customer
     * @param string $idempotencyKey
     * @return array<string, mixed>
     */
    public function execute(
        string $merchantId,
        string $storeId,
        string $cartId,
        array $paymentSelection,
        ?array $customer,
        string $idempotencyKey
    ): array;
}
