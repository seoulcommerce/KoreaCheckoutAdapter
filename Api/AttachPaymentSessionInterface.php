<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api;

use SeoulCommerce\KoreaCheckoutAdapter\Api\Data\AttachPaymentSessionResponseInterface;

interface AttachPaymentSessionInterface
{
    /**
     * @param string $orderId
     * @param string $paymentSessionId
     * @return \SeoulCommerce\KoreaCheckoutAdapter\Api\Data\AttachPaymentSessionResponseInterface
     */
    public function execute(string $orderId, string $paymentSessionId): AttachPaymentSessionResponseInterface;
}
