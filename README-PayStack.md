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
Would you like a step-by-step checklist for testing all your gateways (including Paystack) with the privacy shield, or help setting up ngrok for webhook testing?
