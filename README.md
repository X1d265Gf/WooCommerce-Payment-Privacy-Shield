# WooCommerce Payment Privacy Shield

**Advanced privacy protection for high-risk WooCommerce stores.**

This plugin helps merchants (especially in sensitive niches) **hide their site URL/referrer** when redirecting to payment gateways and ensures **only minimal information** (Order Number + Amount + Real Customer Name) is shown on the gateway's payment page.

## Features

- **Real Customer Name** – Uses actual billing first + last name (no generic placeholders unless empty)
- **Minimal Data Exposure** – Only order number + total amount + customer name sent to gateways
- **Referrer Hiding**:
  - Automatic `href.li` proxy for external links
  - Server-side `Referrer-Policy: strict-origin-when-cross-origin`
  - Custom secure proxy endpoint (`/pay-proxy/`) with nonce + domain whitelist
- **Webhook Security**:
  - Full signature verification (PayFast, Stripe, PayPal)
  - Retry logic with exponential backoff
  - Event processing (auto-complete orders, add notes)
- **Broad Gateway Support** – Works with 20+ gateways including MobiPaid, PayFast, Paystack, Stripe, PayPal, Yoco, Ozow, Zapper, Peach Payments, and more

## How It Works

1. **Privacy Filters** – Intercepts data sent to each gateway and replaces product details with generic safe information.
2. **Referrer Protection** – Prevents your domain from appearing in the `Referer` header sent to payment providers.
3. **Secure Proxy** – Critical "Pay Now" links are routed through your server first (`/pay-proxy/`) for maximum control.
4. **Webhook Handling** – Verifies incoming webhooks securely and processes successful payments automatically.

## Installation

1. Upload the file `payment-gateways-privacy-shield.php` to your site's `/wp-content/mu-plugins/` folder.
2. Clear all caches (site cache, browser, CDN, etc.).
3. Test thoroughly in **Sandbox/Test Mode** for each gateway.
4. Once verified, switch gateways to Live mode.

**No activation needed** — MU-plugins load automatically.

## Usage

The plugin works automatically for most cases.

**For maximum security on "Pay Now" buttons**, use the secure proxy:

```php
$pay_url = $order->get_checkout_payment_url();
$secure_url = home_url( '/pay-proxy/?url=' . base64_encode( $pay_url ) . '&nonce=' . wp_create_nonce( 'pay_proxy_nonce' ) );

echo '<a href="' . esc_url( $secure_url ) . '" class="button">Pay Now Securely</a>';
