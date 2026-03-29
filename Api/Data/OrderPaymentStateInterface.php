<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api\Data;

interface OrderPaymentStateInterface
{
    public const ORDER_ID = 'order_id';
    public const ORDER_NUMBER = 'order_number';
    public const STATE = 'state';
    public const STATUS = 'status';
    public const PAYMENT_SESSION_ID = 'payment_session_id';
    public const LAST_PAYMENT_EVENT_ID = 'last_payment_event_id';
    public const LAST_NORMALIZED_STATUS = 'last_normalized_status';

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

    /**
     * Get payment session id.
     *
     * @return string|null
     */
    public function getPaymentSessionId(): ?string;

    /**
     * Set payment session id.
     *
     * @param string|null $paymentSessionId
     * @return $this
     */
    public function setPaymentSessionId(?string $paymentSessionId): self;

    /**
     * Get last applied payment event id.
     *
     * @return string|null
     */
    public function getLastPaymentEventId(): ?string;

    /**
     * Set last applied payment event id.
     *
     * @param string|null $lastPaymentEventId
     * @return $this
     */
    public function setLastPaymentEventId(?string $lastPaymentEventId): self;

    /**
     * Get last normalized payment status.
     *
     * @return string|null
     */
    public function getLastNormalizedStatus(): ?string;

    /**
     * Set last normalized payment status.
     *
     * @param string|null $lastNormalizedStatus
     * @return $this
     */
    public function setLastNormalizedStatus(?string $lastNormalizedStatus): self;
}
