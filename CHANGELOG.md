# Changelog

## [3.1] - 2026-05-20
**Final Production Release**
- Full idempotency keys for all webhooks
- Refactored retry logic for clarity
- Secure proxy class with Mobipaid support
- Consistent helper functions

## [3.0] - 2026-05-20
**Major Zero-Setup Release**
- Refactored proxy into dedicated `WC_Payment_Proxy` class
- Added nonce + domain whitelist (including Mobipaid)
- Stronger default privacy filters
- Improved structure and logging
- Full secure proxy class (`WC_Payment_Proxy`) with nonce protection and domain whitelist
- Improved `get_proxy_url()` helper function
- Enhanced server-side referrer policy (`strict-origin-when-cross-origin`)
- Comprehensive top-level helper functions

### Changed
- Complete code refactor: no nested functions or classes
- Cleaner architecture and better maintainability
- Consistent version numbering and logging

### Security
- Strong open redirect protection
- Nonce validation on proxy endpoint
- Trusted domains whitelist (including Mobipaid)

---

## [2.9] - 2026-05-19

**Major Refactor**
- All functions moved to top level (no nested definitions)
- `Custom_MobiPaid` class defined at top level
- Improved webhook retry logic with exponential backoff
- Cleaner code structure and performance improvements

---

## [2.8] - 2026-05-18

- Full webhook event processing (auto-complete orders, add notes)
- Retry logic added to all major webhooks
- Enhanced PayPal, Stripe, and PayFast handling

---

## [2.7] - 2026-05-17

- Added full PayPal webhook signature verification
- Improved Stripe webhook verification (HMAC SHA256)
- Added detailed webhook retry helper

---

## [2.6] - 2026-05-16

- Expanded support for top 20 worldwide gateways
- Added basic PayPal webhook verification
- Improved generic privacy filters

---

## [2.5] - 2026-05-15

- Added Stripe webhook signature verification
- Introduced custom secure proxy endpoint (`/pay-proxy/`)
- Enhanced server-side referrer hiding

---

## [2.4] - 2026-05-14

- Added support for major global gateways (Stripe, PayPal, Adyen, Square, etc.)
- Improved generic fallback filters

---

## [2.3] - 2026-05-13

- Merged referrer proxy code directly into MU-plugin
- Removed dependency on old "Advanced WP Hide Referer" plugin
- Added automatic link proxy and meta tag support

---

## [2.2] - 2026-05-12

- Added automatic referrer proxy using `href.li`
- Improved MobiPaid class override with detailed logging

---

## [2.1] - 2026-05-11

- Switched to real customer first + last name (removed generic fallback except when empty)
- Major privacy improvements for payment pages

---

## [2.0] - 2026-05-10

- Added support for South African gateways (MobiPaid, PayFast, Paystack, Yoco, Ozow, Zapper, Peach Payments, NowPayments)
- Initial webhook signature verification stubs
- MU-plugin architecture with detailed logging

---

## [1.0] - 2026-05-08

- Initial working version with MobiPaid class override
- Basic privacy filters for PayFast and Paystack
- Referrer hiding via external service

---

## [0.5] - 2026-05-07

- Added class extension method for MobiPaid
- Basic privacy filters for multiple gateways

---

## [0.3] - 2026-05-06

- First working privacy filters for PayFast and Paystack

---

## [0.2] - 2026-05-05

- Initial MU-plugin structure and logging

---

## [0.1] - 2026-05-04

- Project started
- Basic concept and file structure
