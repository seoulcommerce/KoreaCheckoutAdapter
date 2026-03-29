<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Data;

use Magento\Framework\Api\AbstractSimpleObject;
use SeoulCommerce\KoreaCheckoutAdapter\Api\Data\AttachPaymentSessionResponseInterface;

class AttachPaymentSessionResponse extends AbstractSimpleObject implements AttachPaymentSessionResponseInterface
{
    public function getAttached(): bool
    {
        return (bool) $this->_get(self::ATTACHED);
    }

    public function setAttached(bool $attached): AttachPaymentSessionResponseInterface
    {
        return $this->setData(self::ATTACHED, $attached);
    }

    public function getOrderId(): string
    {
        return (string) $this->_get(self::ORDER_ID);
    }

    public function setOrderId(string $orderId): AttachPaymentSessionResponseInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    public function getOrderNumber(): string
    {
        return (string) $this->_get(self::ORDER_NUMBER);
    }

    public function setOrderNumber(string $orderNumber): AttachPaymentSessionResponseInterface
    {
        return $this->setData(self::ORDER_NUMBER, $orderNumber);
    }

    public function getPaymentSessionId(): string
    {
        return (string) $this->_get(self::PAYMENT_SESSION_ID);
    }

    public function setPaymentSessionId(string $paymentSessionId): AttachPaymentSessionResponseInterface
    {
        return $this->setData(self::PAYMENT_SESSION_ID, $paymentSessionId);
    }
}
