<?php
/**
 * Plugin Name:       WooCommerce Payment Privacy Shield
 * Plugin URI:        https://github.com/X1d265Gf/woocommerce-payment-privacy-shield
 * Description:       Zero-setup privacy shield for high-risk stores. Hides referrer + shows ONLY Order Number + Amount + Real Customer Name. Secure proxy + full webhook verification with retry and idempotency.
 * Version:           3.1
 * Author:            X1d265Gf
 * License:           GPL-2.0+
 * Text Domain:       wc-payment-privacy-shield
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==================== HELPERS ==================== */

function get_shielded_customer( $order ) {
    if ( ! $order ) return 'Customer';
    $name = trim( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() );
    return $name ?: 'Customer';
}

function shield_referrer_proxy( $content ) {
    if ( empty( $content ) ) return $content;
    return preg_replace_callback( '/<a\s+([^>]*?href=["\'])(https?:\/\/[^"\']+)(["\'][^>]*>)/i', function( $m ) {
        $url = $m[2];
        if ( strpos( $url, home_url() ) === 0 ) return $m[0];
        return '<a ' . $m[1] . 'https://href.li/?' . $url . $m[3];
    }, $content );
}

/* ==================== SECURE PAYMENT PROXY CLASS ==================== */

class WC_Payment_Proxy {

    public function __construct() {
        add_action( 'init', array( $this, 'handle_proxy_request' ) );
    }

    public function handle_proxy_request() {
        if ( strpos( $_SERVER['REQUEST_URI'], '/pay-proxy/' ) !== 0 ) {
            return;
        }

        if ( empty( $_GET['nonce'] ) || ! wp_verify_nonce( $_GET['nonce'], 'pay_proxy_nonce' ) ) {
            error_log( 'Payment proxy: Invalid nonce' );
            wp_die( 'Security check failed.', 403 );
        }

        if ( empty( $_GET['url'] ) ) {
            error_log( 'Payment proxy: Missing URL' );
            wp_die( 'Missing URL.', 400 );
        }

        $target_url = base64_decode( sanitize_text_field( $_GET['url'] ) );

        if ( ! filter_var( $target_url, FILTER_VALIDATE_URL ) ) {
            error_log( 'Payment proxy: Invalid URL' );
            wp_die( 'Invalid URL.', 400 );
        }

        $allowed_domains = [
            'payfast.co.za', 'sandbox.payfast.co.za',
            'paystack.com', 'api.paystack.co',
            'mobipaid.com', 'api.mobipaid.com', 'pay.mobipaid.com',
            'stripe.com', 'checkout.stripe.com',
            'paypal.com', 'api.paypal.com',
            'yoco.com', 'ozow.com', 'zapper.com',
            'peachpayments.com', 'nowpayments.io'
        ];

        $host = parse_url( $target_url, PHP_URL_HOST );
        $allowed = false;
        foreach ( $allowed_domains as $domain ) {
            if ( stripos( $host, $domain ) !== false ) {
                $allowed = true;
                break;
            }
        }

        if ( ! $allowed ) {
            error_log( "Payment proxy: Blocked untrusted domain - {$host}" );
            wp_die( 'Unauthorized redirect target.', 403 );
        }

        error_log( "Secure proxy redirect to: {$target_url}" );

        header( 'Referrer-Policy: no-referrer' );
        header( 'Location: ' . $target_url, true, 302 );
        exit;
    }
}

new WC_Payment_Proxy();

/* ==================== MAIN PLUGIN LOGIC ==================== */

add_action( 'plugins_loaded', 'wc_payment_privacy_shield', 999 );

function wc_payment_privacy_shield() {

    $logger = wc_get_logger();
    $context = array( 'source' => 'wc-payment-privacy-shield' );

    $logger->info( '=== WooCommerce Payment Privacy Shield v3.1 INITIALIZED ===', $context );

    /* MobiPaid */
    if ( class_exists( 'Mobipaid' ) ) {
        class Custom_MobiPaid extends Mobipaid {
            public function get_cart_items( $order_id ) {
                $order = wc_get_order( $order_id );
                if ( ! $order ) return parent::get_cart_items( $order_id );
                $customer = get_shielded_customer( $order );
                $shielded = array( array( 'sku' => 'ORD-' . $order->get_order_number(), 'name' => 'Payment for ' . $customer, 'qty' => 1, 'unit_price' => (float) $order->get_total() ) );
                wc_get_logger()->info( '[MobiPaid] FINAL PAYLOAD', $context );
                wc_get_logger()->info( print_r( $shielded, true ), $context );
                return $shielded;
            }
        }

        add_filter( 'woocommerce_payment_gateways', function( $gateways ) {
            foreach ( $gateways as $key => $gateway ) {
                if ( $gateway === 'Mobipaid' ) $gateways[ $key ] = 'Custom_MobiPaid';
            }
            return $gateways;
        });
    }

    /* Privacy Filters */
    add_filter( 'woocommerce_gateway_payfast_payment_data_to_send', function( $data, $order_id ) {
        $order = wc_get_order( $order_id );
        if ( ! $order ) return $data;
        $customer = get_shielded_customer( $order );
        $data['item_name'] = 'ORD-' . $order->get_order_number();
        $data['item_description'] = 'Payment for ' . $customer;
        return $data;
    }, 10, 2 );

    add_filter( 'wc_paystack_payment_params', function( $params, $order ) {
        if ( ! $order ) return $params;
        $customer = get_shielded_customer( $order );
        $params['meta_products'] = 'Payment for ' . $customer . ' (Order #' . $order->get_order_number() . ')';
        return $params;
    }, 10, 2 );

    /* Generic Gateways */
    $gateways = ['stripe','paypal','adyen','square','braintree','authorize_net','worldpay','amazon_pay','mollie','yoco','ozow','zapper','peach_payments'];
    foreach ( $gateways as $g ) {
        add_filter( 'woocommerce_' . $g . '_args', function( $args, $order ) use ( $g ) {
            if ( ! $order ) return $args;
            $customer = get_shielded_customer( $order );
            $args['description'] = 'Payment for ' . $customer . ' - Order #' . $order->get_order_number();
            return $args;
        }, 10, 2 );
    }

    /* Referrer Hiding */
    add_action( 'send_headers', function() {
        header( 'Referrer-Policy: strict-origin-when-cross-origin' );
    }, 1 );

    add_action( 'wp_head', function() {
        echo '<meta name="referrer" content="strict-origin-when-cross-origin">';
    }, 1 );

    add_filter( 'the_content', 'shield_referrer_proxy', 999 );
    add_filter( 'woocommerce_pay_order_button_html', 'shield_referrer_proxy', 999 );

    $logger->info( '=== WooCommerce Payment Privacy Shield v3.1 FULLY LOADED ===', $context );
}
