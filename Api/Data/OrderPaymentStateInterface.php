<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api\Data;

interface OrderPaymentStateInterface
{
    public const ORDER_ID = 'order_id';
    public const INCREMENT_ID = 'increment_id';
    public const STATE = 'state';
    public const STATUS = 'status';
    public const PAYMENT_SESSION_ID = 'payment_session_id';
    public const LAST_PAYMENT_EVENT_ID = 'last_payment_event_id';
    public const LAST_NORMALIZED_STATUS = 'last_normalized_status';
}
