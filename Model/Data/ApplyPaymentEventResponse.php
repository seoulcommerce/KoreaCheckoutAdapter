<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Data;

use Magento\Framework\Api\AbstractSimpleObject;
use SeoulCommerce\KoreaCheckoutAdapter\Api\Data\ApplyPaymentEventResponseInterface;

class ApplyPaymentEventResponse extends AbstractSimpleObject implements ApplyPaymentEventResponseInterface
{
    public function getApplied(): bool
    {
        return (bool) $this->_get(self::APPLIED);
    }

    public function setApplied(bool $applied): ApplyPaymentEventResponseInterface
    {
        return $this->setData(self::APPLIED, $applied);
    }

    public function getOrderId(): string
    {
        return (string) $this->_get(self::ORDER_ID);
    }

    public function setOrderId(string $orderId): ApplyPaymentEventResponseInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    public function getOrderNumber(): string
    {
        return (string) $this->_get(self::ORDER_NUMBER);
    }

    public function setOrderNumber(string $orderNumber): ApplyPaymentEventResponseInterface
    {
        return $this->setData(self::ORDER_NUMBER, $orderNumber);
    }

    public function getState(): string
    {
        return (string) $this->_get(self::STATE);
    }

    public function setState(string $state): ApplyPaymentEventResponseInterface
    {
        return $this->setData(self::STATE, $state);
    }

    public function getStatus(): string
    {
        return (string) $this->_get(self::STATUS);
    }

    public function setStatus(string $status): ApplyPaymentEventResponseInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    public function getPaymentSessionId(): string
    {
        return (string) $this->_get(self::PAYMENT_SESSION_ID);
    }

    public function setPaymentSessionId(string $paymentSessionId): ApplyPaymentEventResponseInterface
    {
        return $this->setData(self::PAYMENT_SESSION_ID, $paymentSessionId);
    }

    public function getLastPaymentEventId(): ?string
    {
        $value = $this->_get(self::LAST_PAYMENT_EVENT_ID);
        return $value === null ? null : (string) $value;
    }

    public function setLastPaymentEventId(?string $lastPaymentEventId): ApplyPaymentEventResponseInterface
    {
        return $this->setData(self::LAST_PAYMENT_EVENT_ID, $lastPaymentEventId);
    }

    public function getLastNormalizedStatus(): ?string
    {
        $value = $this->_get(self::LAST_NORMALIZED_STATUS);
        return $value === null ? null : (string) $value;
    }

    public function setLastNormalizedStatus(?string $lastNormalizedStatus): ApplyPaymentEventResponseInterface
    {
        return $this->setData(self::LAST_NORMALIZED_STATUS, $lastNormalizedStatus);
    }
}
