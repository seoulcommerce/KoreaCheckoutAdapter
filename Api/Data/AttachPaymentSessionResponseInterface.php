<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api\Data;

interface AttachPaymentSessionResponseInterface
{
    public const ATTACHED = 'attached';
    public const ORDER_ID = 'order_id';
    public const ORDER_NUMBER = 'order_number';
    public const PAYMENT_SESSION_ID = 'payment_session_id';

    public function getAttached(): bool;

    public function setAttached(bool $attached): self;

    public function getOrderId(): string;

    public function setOrderId(string $orderId): self;

    public function getOrderNumber(): string;

    public function setOrderNumber(string $orderNumber): self;

    public function getPaymentSessionId(): string;

    public function setPaymentSessionId(string $paymentSessionId): self;
}
