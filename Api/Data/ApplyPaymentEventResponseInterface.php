<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api\Data;

interface ApplyPaymentEventResponseInterface
{
    public const APPLIED = 'applied';
    public const ORDER_ID = 'order_id';
    public const ORDER_NUMBER = 'order_number';
    public const STATE = 'state';
    public const STATUS = 'status';
    public const PAYMENT_SESSION_ID = 'payment_session_id';
    public const LAST_PAYMENT_EVENT_ID = 'last_payment_event_id';
    public const LAST_NORMALIZED_STATUS = 'last_normalized_status';

    public function getApplied(): bool;

    public function setApplied(bool $applied): self;

    public function getOrderId(): string;

    public function setOrderId(string $orderId): self;

    public function getOrderNumber(): string;

    public function setOrderNumber(string $orderNumber): self;

    public function getState(): string;

    public function setState(string $state): self;

    public function getStatus(): string;

    public function setStatus(string $status): self;

    public function getPaymentSessionId(): string;

    public function setPaymentSessionId(string $paymentSessionId): self;

    public function getLastPaymentEventId(): ?string;

    public function setLastPaymentEventId(?string $lastPaymentEventId): self;

    public function getLastNormalizedStatus(): ?string;

    public function setLastNormalizedStatus(?string $lastNormalizedStatus): self;
}
