<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api\Data;

interface CreatePendingOrderResponseInterface
{
    public const PLATFORM_TYPE = 'platform_type';
    public const ORDER_ID = 'order_id';
    public const ORDER_NUMBER = 'order_number';
    public const STATE = 'state';
    public const STATUS = 'status';

    public function getPlatformType(): string;

    public function setPlatformType(string $platformType): self;

    public function getOrderId(): string;

    public function setOrderId(string $orderId): self;

    public function getOrderNumber(): string;

    public function setOrderNumber(string $orderNumber): self;

    public function getState(): string;

    public function setState(string $state): self;

    public function getStatus(): string;

    public function setStatus(string $status): self;
}
