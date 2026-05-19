Paystack Sandbox Testing Guide (2026)
Paystack provides a fully functional Sandbox/Test Mode for safe testing without real money. Here’s how to explore and test it effectively with your WooCommerce setup and privacy shield plugin.
1. Enable Sandbox Mode in Paystack Dashboard
	1	Log in to your Paystack Dashboard.
	2	Toggle Test Mode (top-right corner) — it should show red “Test”.
	3	Go to Settings → API Keys & Webhooks.
	4	Copy your Test Public Key and Test Secret Key.
2. Configure in WooCommerce
	1	Go to WooCommerce → Settings → Payments → Paystack.
	2	Enable the gateway.
	3	Check Test Mode.
	4	Paste your Test Public Key and Test Secret Key.
	5	Save changes.
Your plugin’s privacy filters (real customer name + order number only) will automatically apply in both test and live modes.
3. Test Cards & Payment Methods
Successful Cards (most commonly used):
Card Number
Expiry
CVV
PIN / OTP
Notes
4084 0840 8408 4081
Any future
408
—
No validation
5078 5078 5078 5078
Any future
081
1111
PIN validation
5060 6666 6666 6666 666
Any future
123
1234
PIN + OTP
5192 6027 2058 4796
Any future
123
—
Bank auth simulation
Failed Cards:
	•	4000 0000 0000 0002 — Declined
	•	4000 0000 0000 0061 — Insufficient funds
Other Methods:
	•	Bank transfers, USSD, QR code — all work in test mode.
4. Testing Your Privacy Shield Features
	1	Add a product to cart and proceed to checkout.
	2	Use one of the test cards above.
	3	On the Paystack payment page, verify:
	◦	Only customer name (e.g., “Payment for John Doe”)
	◦	Order number (e.g., “ORD-12345”)
	◦	Correct total amount
	◦	No product names or SKUs visible
Your plugin’s filters should ensure this works automatically.
5. Webhook Testing in Sandbox
	•	In test mode, Paystack sends webhooks hourly for 10 hours for each event.
	•	Use tools like ngrok or localtunnel to expose your site locally.
	•	In Paystack Dashboard → Settings → Webhooks, add your URL (e.g., https://your-site.com/wc-api/wc_paystack/).
	•	Click “Send Test Webhook” to simulate events.
Your plugin’s webhook handler will log verification and process events (e.g., mark order as completed).
6. Common Testing Tips & Issues
	•	Test Mode vs Live: Always double-check the toggle.
	•	Cache: Clear WooCommerce, browser, and server cache after changes.
	•	Privacy Check: Inspect the Paystack page source/network tab.
	•	Webhook Delays: Sandbox webhooks can be slow — wait or use the test button.
	•	Mobile Testing: Use Paystack test app or browser dev tools.


1. Paystack
	•	Test Mode: Toggle in Dashboard → Use Test Keys
	•	Test Cards: 4084 0840 8408 4081, 5060 6666 6666 6666 666, etc.
	•	Privacy Check: Look for “Payment for John Doe” + Order #
	•	Webhook: Use “Send Test Webhook” button
2. PayFast
Sandbox Setup
	1	Go to sandbox.payfast.co.za
	2	Create/login to sandbox merchant account
	3	Copy Merchant ID, Merchant Key, and set Passphrase
WooCommerce Settings
	•	Enable PayFast → Check Sandbox Mode
	•	Paste sandbox credentials
Test Cards / Methods
	•	Card: 4242 4242 4242 4242 (any future expiry, CVV 123)
	•	EFT / Ozow simulation available
Privacy Check
	•	On PayFast page, verify only “Payment for John Doe” + “ORD-XXXXX”
Webhook Testing
	•	Webhooks fire instantly in sandbox
	•	Test URL: https://yoursite.com/wc-api/wc_gateway_payfast/
	•	Use sandbox dashboard “Send Test ITN”
3. MobiPaid
Sandbox Setup
	1	Log into MobiPaid merchant portal
	2	Enable Test Mode in settings
	3	Use test POS link or API credentials
Privacy Check
	•	On MobiPaid payment page, confirm only generic line item with customer name + order number
Testing Tips
	•	Use test cards provided in MobiPaid dashboard
	•	Webhooks: Configure callback URL and trigger test payments
4. Yoco
Sandbox Setup
	1	Dashboard → Switch to Test Mode
	2	Use test public/private keys
Test Cards
	•	4111 1111 1111 1111 (Visa)
	•	5555 5555 5555 4444 (Mastercard)
Privacy Check
	•	Popup should show only “Payment for John Doe (Order #12345)”
5. Ozow
Sandbox Setup
	1	Log into Ozow merchant portal → Test environment
	2	Use test bank accounts
Testing
	•	Select “Test Bank” during checkout
	•	Privacy: Should show only generic description
6. Zapper
Sandbox
	•	Use Zapper test merchant account
	•	Scan test QR codes or use test links
Privacy Check
	•	Payment screen should display minimal info
7. Peach Payments
Sandbox
	•	Use Peach test credentials
	•	Test cards provided in their docs
Webhook
	•	Configure webhook URL and use test events
8. NowPayments (Crypto)
Test Mode
	•	Use test API key
	•	Test with testnet coins (BTC testnet, etc.)
Privacy
	•	Description field should show generic customer info
9. Stripe

Test Mode
	•	Use pk_test_ and sk_test_ keys
	•	Test cards: 4242 4242 4242 4242, 4000 0000 0000 0002 (declined)
Privacy
	•	Metadata and description filtered by plugin
Webhook Testing
	•	Use Stripe CLI: stripe listen --forward-to https://yoursite.com/wc-api/wc_stripe/

11. PayPal
Sandbox
	•	Use developer.paypal.com sandbox accounts
	•	Test buyer/seller accounts
Test Cards
	•	Use sandbox credit cards from PayPal docs
Webhook
	•	Configure webhook URL in sandbox dashboard

General Testing Workflow for All Gateways
	1	Enable Sandbox/Test Mode in both gateway dashboard and WooCommerce.
	2	Place test order with real billing name.
	3	Verify on gateway page: Only customer name + order number + amount.
	4	Check referrer in browser DevTools (Network tab) — should be masked.
	5	Trigger webhook and confirm order status updates + logs.


