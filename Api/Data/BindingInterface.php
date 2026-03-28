<?php

declare(strict_types=1);

namespace SeoulCommerce\KoreaCheckoutAdapter\Api\Data;

interface BindingInterface
{
    public const ORDER_ID = 'order_id';
    public const INCREMENT_ID = 'increment_id';
    public const PAYMENT_SESSION_ID = 'payment_session_id';
    public const PLATFORM_EVENT_ID_LAST_APPLIED = 'platform_event_id_last_applied';
    public const GATEWAY = 'gateway';
    public const PAYMENT_METHOD = 'payment_method';
    public const BINDING_STATUS = 'binding_status';
    public const LAST_NORMALIZED_STATUS = 'last_normalized_status';
    public const LAST_GATEWAY_TRANSACTION_REF = 'last_gateway_transaction_ref';
}
