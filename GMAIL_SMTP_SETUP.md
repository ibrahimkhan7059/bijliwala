# Gmail SMTP Configuration for Admin Email Notifications

## Overview
Your Bijliwala e-commerce system is now configured to send admin email notifications whenever a customer places an order. The system uses **Gmail SMTP** for sending emails - completely **FREE** and reliable.

---

## Setup Instructions

### Step 1: Enable 2-Step Verification on Gmail

1. Go to [Google Account Security Settings](https://myaccount.google.com/security)
2. Look for **"2-Step Verification"** section
3. Click **"Enable"** or **"Get started with 2-Step Verification"**
4. Follow Google's verification process (they'll send code to your phone)
5. **IMPORTANT**: Don't close this page yet!

---

### Step 2: Generate Gmail App Password

1. After enabling 2-Step Verification, go back to [Google Account Security](https://myaccount.google.com/security)
2. Scroll down and look for **"App passwords"** section
3. If you don't see it:
   - Make sure 2-Step Verification is enabled
   - Select "Mail" and "Windows Computer" (or your device)
4. Google will generate a **16-character password**
5. **COPY THIS PASSWORD** - You'll need it in the next step

**Example Generated Password:**
```
abcd efgh ijkl mnop
```

---

### Step 3: Update .env File

Open `c:\xampp\htdocs\bijliwala\.env` and update these lines:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-actual-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-actual-email@gmail.com"
MAIL_FROM_NAME="Bijliwala"
```

**Replace with your actual values:**
- `your-actual-email@gmail.com` → Your Gmail address (e.g., `admin@gmail.com`)
- `your-16-char-app-password` → The 16-character password from Step 2 (without spaces)

**Example:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=bijliwala.admin@gmail.com
MAIL_PASSWORD=abcdefghijklmnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="bijliwala.admin@gmail.com"
MAIL_FROM_NAME="Bijliwala"
```

---

### Step 4: Set Admin Email in Settings

1. Go to your **Admin Dashboard**
2. Navigate to **Settings**
3. Find the field: **"Orders Contact Email"** (should be `orders_contact_email`)
4. Enter the email address where you want to receive order notifications
5. **SAVE SETTINGS**

**Example:**
```
orders_contact_email = admin@bijliwala.com
```

---

### Step 5: Configure Queue (Optional but Recommended)

For better performance, emails can be sent asynchronously:

**Update `.env`:**
```env
QUEUE_CONNECTION=database
```

**Then run these commands:**
```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```

---

## Testing Email Sending

### Method 1: Test via Artisan Tinker

```bash
# Open Laravel Tinker
php artisan tinker

# Send test email
Mail::raw('Test email from Bijliwala', function($message) {
    $message->to('your-email@gmail.com')
            ->subject('Test Email');
});

# You should receive the email within seconds
# Type exit to close Tinker
```

### Method 2: Place a Test Order

1. Go to your website
2. Add a product to cart
3. Complete checkout process
4. Check your admin email for the order notification

---

## What Admin Receives

When a customer places an order, you'll receive a professional HTML email with:

✅ **Order Information**
- Order number (e.g., AJ001)
- Order date & time
- Payment method (Bank Transfer / COD)
- Payment status

✅ **Customer Details**
- Customer name
- Phone number (clickable link to call)
- Email address (if registered)

✅ **Complete Order Items**
- Product names
- Quantities
- Individual prices
- Line item totals

✅ **Pricing Breakdown**
- Subtotal
- Delivery charges (or FREE if bank transfer)
- **Total Amount** (highlighted)

✅ **Delivery Address**
- Full shipping address
- Customer contact info

✅ **Payment Details**
- For Bank Transfer: Link to payment proof
- For COD: Amount to collect

✅ **Quick Action Buttons**
- "View Order Details" → Direct link to admin panel
- "Call Customer" → Direct phone link

---

## Troubleshooting

### Problem: Email Not Sending

**Check 1: Is Gmail SMTP configured in .env?**
```bash
# Verify these settings exist:
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
```

**Check 2: Is the app password correct?**
- Ensure you used the 16-character **app password**, NOT your regular Gmail password
- Remove any spaces from the password

**Check 3: Is 2-Step Verification enabled?**
- Gmail requires 2-Step Verification for app passwords
- Go to [Google Security Settings](https://myaccount.google.com/security) and verify

**Check 4: Check Laravel Logs**
```bash
# View recent errors
tail -f storage/logs/laravel.log
```

### Problem: "Authentication failed"

**Solution:**
1. Go to [Google Security Settings](https://myaccount.google.com/security)
2. Regenerate a new app password
3. Update `.env` with the new password

### Problem: "Connection refused"

**Solution:**
- Check your internet connection
- Verify Gmail SMTP port (587) is not blocked by firewall
- Try using port 465 with encryption `ssl` (alternative)

### Problem: Email going to Spam

**Solution:**
1. Check your spam/junk folder
2. Mark the email as "Not Spam"
3. Add the sender email to contacts

---

## Important Security Notes

⚠️ **Never share your app password**
- Keep `.env` file safe
- Don't commit `.env` to git
- Use environment variables in production

⚠️ **Gmail App Passwords**
- App passwords only work with 2-Step Verification enabled
- Each app can have its own password
- You can revoke passwords anytime

🔐 **Best Practice for Production:**
- Use environment variables
- Store sensitive data in `.env.production`
- Never hardcode passwords in code

---

## Production Deployment

For production servers, use this setup:

**`.env.production`:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=${GMAIL_USERNAME}
MAIL_PASSWORD=${GMAIL_PASSWORD}
MAIL_ENCRYPTION=tls
```

Then set environment variables on your server.

---

## Alternative Email Services

If you prefer not to use Gmail, here are alternatives:

### Mailtrap (Free Testing)
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
```

### SendGrid
```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=your-sendgrid-key
```

### AWS SES
```env
MAIL_MAILER=ses
SES_SECRET=your-aws-secret
SES_KEY=your-aws-key
```

---

## Email Template Customization

Edit: `resources/views/emails/order-placed.blade.php`

You can customize:
- Colors and styling
- Email content
- Fields to display
- Action buttons

---

## Summary

✅ **Steps Completed:**
1. ✓ Email Mailable class created (`OrderPlaced.php`)
2. ✓ Email template created (`order-placed.blade.php`)
3. ✓ OrderController updated with email sending
4. ✓ `.env` configured for Gmail SMTP

🎯 **Next Steps:**
1. Enable 2-Step Verification on your Gmail account
2. Generate an app password
3. Update `.env` with Gmail credentials
4. Set admin email in Settings
5. Test by placing an order
6. Enjoy automated order notifications! 🎉

---

## Support

If you encounter any issues:

1. **Check logs:** `storage/logs/laravel.log`
2. **Verify settings:** `.env` file configuration
3. **Test connection:** Use `php artisan tinker`
4. **Check Gmail:** [Gmail Security Settings](https://myaccount.google.com/security)

**Status:** ✅ Email notification system ready to use!
