<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Model\Data;

use Magento\Framework\Api\AbstractSimpleObject;
use SeoulCommerce\KoreaCheckoutAdapter\Api\Data\CreatePendingOrderResponseInterface;

class CreatePendingOrderResponse extends AbstractSimpleObject implements CreatePendingOrderResponseInterface
{
    public function getPlatformType(): string
    {
        return (string) $this->_get(self::PLATFORM_TYPE);
    }

    public function setPlatformType(string $platformType): CreatePendingOrderResponseInterface
    {
        return $this->setData(self::PLATFORM_TYPE, $platformType);
    }

    public function getOrderId(): string
    {
        return (string) $this->_get(self::ORDER_ID);
    }

    public function setOrderId(string $orderId): CreatePendingOrderResponseInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    public function getOrderNumber(): string
    {
        return (string) $this->_get(self::ORDER_NUMBER);
    }

    public function setOrderNumber(string $orderNumber): CreatePendingOrderResponseInterface
    {
        return $this->setData(self::ORDER_NUMBER, $orderNumber);
    }

    public function getState(): string
    {
        return (string) $this->_get(self::STATE);
    }

    public function setState(string $state): CreatePendingOrderResponseInterface
    {
        return $this->setData(self::STATE, $state);
    }

    public function getStatus(): string
    {
        return (string) $this->_get(self::STATUS);
    }

    public function setStatus(string $status): CreatePendingOrderResponseInterface
    {
        return $this->setData(self::STATUS, $status);
    }
}
