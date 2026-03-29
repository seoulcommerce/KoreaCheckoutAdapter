<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api;

use SeoulCommerce\KoreaCheckoutAdapter\Api\Data\OrderPaymentStateInterface;

interface GetOrderPaymentStateInterface
{
    /**
     * @param string $orderId
     * @return \SeoulCommerce\KoreaCheckoutAdapter\Api\Data\OrderPaymentStateInterface
     */
    public function execute(string $orderId): OrderPaymentStateInterface;
}
