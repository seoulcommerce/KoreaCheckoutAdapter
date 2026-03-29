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

    /**
     * Get platform type.
     *
     * @return string
     */
    public function getPlatformType(): string;

    /**
     * Set platform type.
     *
     * @param string $platformType
     * @return $this
     */
    public function setPlatformType(string $platformType): self;

    /**
     * Get Magento order id.
     *
     * @return string
     */
    public function getOrderId(): string;

    /**
     * Set Magento order id.
     *
     * @param string $orderId
     * @return $this
     */
    public function setOrderId(string $orderId): self;

    /**
     * Get Magento order number.
     *
     * @return string
     */
    public function getOrderNumber(): string;

    /**
     * Set Magento order number.
     *
     * @param string $orderNumber
     * @return $this
     */
    public function setOrderNumber(string $orderNumber): self;

    /**
     * Get Magento order state.
     *
     * @return string
     */
    public function getState(): string;

    /**
     * Set Magento order state.
     *
     * @param string $state
     * @return $this
     */
    public function setState(string $state): self;

    /**
     * Get Magento order status.
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Set Magento order status.
     *
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self;
}
