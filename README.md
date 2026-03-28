# SeoulCommerce_KoreaCheckoutAdapter

Magento module for the Korea checkout adapter boundary.

## Purpose
- create the canonical pending Magento order
- attach `paymentSessionId` to Magento
- apply normalized payment events
- expose current Magento payment state

## REST Surface
- `POST /rest/V1/seoulcommerce-korea-checkout/orders/pending`
- `POST /rest/V1/seoulcommerce-korea-checkout/orders/{orderId}/attach-session`
- `POST /rest/V1/seoulcommerce-korea-checkout/orders/{orderId}/apply-payment-event`
- `GET /rest/V1/seoulcommerce-korea-checkout/orders/{orderId}/payment-state`

## Included Now
- declarative schema for `seoulcommerce_korea_checkout_binding`
- masked-cart to Magento order placement flow
- session binding persistence and conflict checks
- payment additional-information mirroring
- normalized state application with default status mapping
- paid-state invoice attempt when the order is invoiceable
- payment state read endpoint for reconciliation

## Remaining Hardening
- adapter-side idempotency persistence for repeated pending-order requests
- stricter compare-and-apply rules for out-of-order/conflicting events
- project-specific payment method assignment before order placement
- admin/support visibility enhancements
