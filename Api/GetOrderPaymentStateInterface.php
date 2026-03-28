<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api;

interface GetOrderPaymentStateInterface
{
    /**
     * @param string $orderId
     * @return array<string, mixed>
     */
    public function execute(string $orderId): array;
}
