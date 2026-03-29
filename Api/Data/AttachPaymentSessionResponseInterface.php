<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api\Data;

interface AttachPaymentSessionResponseInterface
{
    public const ATTACHED = 'attached';
    public const ORDER_ID = 'order_id';
    public const ORDER_NUMBER = 'order_number';
    public const PAYMENT_SESSION_ID = 'payment_session_id';

    /**
     * Get attach result.
     *
     * @return bool
     */
    public function getAttached(): bool;

    /**
     * Set attach result.
     *
     * @param bool $attached
     * @return $this
     */
    public function setAttached(bool $attached): self;

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
     * Get payment session id.
     *
     * @return string
     */
    public function getPaymentSessionId(): string;

    /**
     * Set payment session id.
     *
     * @param string $paymentSessionId
     * @return $this
     */
    public function setPaymentSessionId(string $paymentSessionId): self;
}
