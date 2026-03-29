<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Data;

use Magento\Framework\Api\AbstractSimpleObject;
use SeoulCommerce\KoreaCheckoutAdapter\Api\Data\OrderPaymentStateInterface;

class OrderPaymentState extends AbstractSimpleObject implements OrderPaymentStateInterface
{
    public function getOrderId(): string
    {
        return (string) $this->_get(self::ORDER_ID);
    }

    public function setOrderId(string $orderId): OrderPaymentStateInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    public function getOrderNumber(): string
    {
        return (string) $this->_get(self::ORDER_NUMBER);
    }

    public function setOrderNumber(string $orderNumber): OrderPaymentStateInterface
    {
        return $this->setData(self::ORDER_NUMBER, $orderNumber);
    }

    public function getState(): string
    {
        return (string) $this->_get(self::STATE);
    }

    public function setState(string $state): OrderPaymentStateInterface
    {
        return $this->setData(self::STATE, $state);
    }

    public function getStatus(): string
    {
        return (string) $this->_get(self::STATUS);
    }

    public function setStatus(string $status): OrderPaymentStateInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    public function getPaymentSessionId(): ?string
    {
        $value = $this->_get(self::PAYMENT_SESSION_ID);
        return $value === null ? null : (string) $value;
    }

    public function setPaymentSessionId(?string $paymentSessionId): OrderPaymentStateInterface
    {
        return $this->setData(self::PAYMENT_SESSION_ID, $paymentSessionId);
    }

    public function getLastPaymentEventId(): ?string
    {
        $value = $this->_get(self::LAST_PAYMENT_EVENT_ID);
        return $value === null ? null : (string) $value;
    }

    public function setLastPaymentEventId(?string $lastPaymentEventId): OrderPaymentStateInterface
    {
        return $this->setData(self::LAST_PAYMENT_EVENT_ID, $lastPaymentEventId);
    }

    public function getLastNormalizedStatus(): ?string
    {
        $value = $this->_get(self::LAST_NORMALIZED_STATUS);
        return $value === null ? null : (string) $value;
    }

    public function setLastNormalizedStatus(?string $lastNormalizedStatus): OrderPaymentStateInterface
    {
        return $this->setData(self::LAST_NORMALIZED_STATUS, $lastNormalizedStatus);
    }
}
