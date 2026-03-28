<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Service;

use Magento\Sales\Api\Data\OrderInterface;

class PaymentMetadataWriter
{
    /**
     * @param array<string, mixed> $metadata
     */
    public function write(OrderInterface $order, array $metadata): void
    {
        $payment = $order->getPayment();

        if (!$payment) {
            return;
        }

        foreach ($metadata as $key => $value) {
            if ($value === null) {
                continue;
            }

            $payment->setAdditionalInformation($key, $value);
        }

        $order->setPayment($payment);
    }
}
