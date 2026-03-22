# Admin Order Notification Setup Guide

## Overview
When a customer places an order, an automated email notification is sent to the admin email address configured in the site settings. This helps you stay updated about new orders in real-time.

## Configuration Steps

### 1. Set Admin Email in Settings
You need to configure the "Orders Contact Email" in your admin panel settings:

1. Go to Admin Dashboard → Settings
2. Find the field: **"Orders Contact Email"**
3. Enter your email address (e.g., admin@bijliwala.com or your personal email)
4. Save the settings

### 2. Email Configuration in .env File
For the emails to actually send, you need to configure your mail service in the `.env` file.

**Option A: Using Gmail (Recommended for Testing)**
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-specific-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Steps for Gmail:**
1. Enable 2-Step Verification on your Gmail account
2. Generate an "App Password" (not your regular password)
3. Use the App Password in MAIL_PASSWORD field

**Option B: Using Mailtrap (Free Testing Service)**
```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 3. How Email Notifications Work

#### When an Order is Placed:
1. ✅ Customer completes checkout
2. ✅ Order is saved to database
3. ✅ Admin notification email is automatically sent
4. ✅ Email includes:
   - Order number
   - Customer name and phone
   - Complete order items list
   - Delivery address
   - Payment method and status
   - Total amount (with/without delivery charges)
   - Payment proof link (for bank transfer orders)
   - Quick action buttons

#### Email Features:
- **Professional Design**: Beautiful HTML email template
- **Complete Details**: All order information in one email
- **Quick Actions**: Direct links to view order or call customer
- **Real-time**: Sent immediately when order is placed
- **Error Handling**: If email fails, order is still placed successfully

### 4. What You'll Receive

#### Email Subject:
`New Order #AJ001 - Bijliwala`

#### Email Contents:
1. **Order Summary**
   - Order number
   - Order date & time
   - Payment method
   - Payment status

2. **Customer Information**
   - Name
   - Phone number (clickable link to call)
   - Email (if registered user)

3. **Order Items**
   - Product names
   - Quantities
   - Individual prices
   - Line totals

4. **Pricing Breakdown**
   - Subtotal
   - Delivery charges (or "FREE ✓" for bank transfers)
   - Total amount (highlighted)

5. **Delivery Address**
   - Full shipping address
   - Customer phone number

6. **Payment Information**
   - If Bank Transfer: Shows payment proof link
   - If COD: Shows delivery charges amount

### 5. Troubleshooting

#### Email Not Sending?

**Check 1: Is admin email configured?**
- Go to Settings and verify "Orders Contact Email" is filled

**Check 2: Are .env mail settings correct?**
- Verify MAIL_MAILER, MAIL_HOST, MAIL_PORT are set
- Check MAIL_USERNAME and MAIL_PASSWORD are correct

**Check 3: Check Laravel logs**
- Look in `storage/logs/laravel.log` for error messages
- Search for "Admin order notification"

**Check 4: Is QUEUE_CONNECTION set to database?**
- Currently set in .env: `QUEUE_CONNECTION=database`
- Emails are queued for better performance

**To process queued jobs:**
```bash
php artisan queue:work
```

#### Not Receiving Emails in Gmail?
1. Check Spam folder
2. Verify sender email is whitelisted
3. Check Gmail "Less secure apps" settings

#### Using Mailtrap?
- Check Mailtrap dashboard → Inbox
- Emails appear there for testing before production

### 6. Production Setup (Optional)

For production, use a proper email service:

**Option 1: AWS SES (Amazon Simple Email Service)**
- Most cost-effective for high volume
- Pricing: $0.10 per 1,000 emails

**Option 2: SendGrid**
- Reliable and easy setup
- Free tier: 100 emails/day

**Option 3: Mailgun**
- Professional email service
- Free tier: 5,000 emails/month

### 7. Advanced Configuration (Optional)

#### Queue Processing
To process emails in background (recommended for high traffic):

```bash
# Start queue worker
php artisan queue:work

# Or using supervisor (production)
php artisan queue:work --daemon
```

#### Customizing Email Template
Edit: `resources/views/emails/order-placed.blade.php`

### 8. Monitoring Email Logs

Check if emails are being sent:
```bash
tail -f storage/logs/laravel.log | grep "order notification"
```

### Support
If you need help setting up email notifications, contact support with:
- Your .env configuration (without passwords)
- Error messages from logs
- Screenshot of Settings page

---

**Status**: ✅ Email notification system is ready to use!
