<?php

/**
 * Email Configuration Test Script
 * 
 * This script will test if your Gmail SMTP configuration is working properly.
 * Place this file in the project root and run: php test_email_config.php
 */

// Load Laravel bootstrap
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║         EMAIL CONFIGURATION TEST - BIJLIWALA                  ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Step 1: Check .env Configuration
echo "📋 STEP 1: Checking .env Configuration\n";
echo "─────────────────────────────────────────────────────────────────\n";

$mailConfig = [
    'MAIL_MAILER' => env('MAIL_MAILER'),
    'MAIL_HOST' => env('MAIL_HOST'),
    'MAIL_PORT' => env('MAIL_PORT'),
    'MAIL_USERNAME' => env('MAIL_USERNAME'),
    'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
    'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
    'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
];

foreach ($mailConfig as $key => $value) {
    if ($key === 'MAIL_PASSWORD') {
        echo "✓ {$key}: " . (str_repeat('*', strlen($value))) . "\n";
    } else {
        echo "✓ {$key}: {$value}\n";
    }
}

// Step 2: Verify Required Settings
echo "\n📋 STEP 2: Verifying Required Settings\n";
echo "─────────────────────────────────────────────────────────────────\n";

$errors = [];

if (env('MAIL_MAILER') !== 'smtp') {
    $errors[] = "❌ MAIL_MAILER must be 'smtp', currently: " . env('MAIL_MAILER');
} else {
    echo "✓ MAIL_MAILER is set to 'smtp'\n";
}

if (env('MAIL_HOST') !== 'smtp.gmail.com') {
    $errors[] = "❌ MAIL_HOST must be 'smtp.gmail.com', currently: " . env('MAIL_HOST');
} else {
    echo "✓ MAIL_HOST is set to 'smtp.gmail.com'\n";
}

if (env('MAIL_PORT') != 587) {
    $errors[] = "❌ MAIL_PORT must be '587', currently: " . env('MAIL_PORT');
} else {
    echo "✓ MAIL_PORT is set to '587'\n";
}

if (!env('MAIL_USERNAME')) {
    $errors[] = "❌ MAIL_USERNAME is not set";
} else {
    echo "✓ MAIL_USERNAME is set: " . env('MAIL_USERNAME') . "\n";
}

if (!env('MAIL_PASSWORD')) {
    $errors[] = "❌ MAIL_PASSWORD is not set";
} else {
    echo "✓ MAIL_PASSWORD is set (length: " . strlen(env('MAIL_PASSWORD')) . " characters)\n";
}

if (env('MAIL_ENCRYPTION') !== 'tls') {
    $errors[] = "❌ MAIL_ENCRYPTION must be 'tls', currently: " . env('MAIL_ENCRYPTION');
} else {
    echo "✓ MAIL_ENCRYPTION is set to 'tls'\n";
}

// Step 3: Check Admin Email in Settings
echo "\n📋 STEP 3: Checking Admin Email in Settings Table\n";
echo "─────────────────────────────────────────────────────────────────\n";

try {
    $adminEmail = \DB::table('settings')
        ->where('key', 'orders_contact_email')
        ->value('value');

    if ($adminEmail) {
        echo "✓ Orders Contact Email is set: {$adminEmail}\n";
    } else {
        $errors[] = "⚠️  Orders Contact Email is not set in settings table";
        echo "⚠️  Orders Contact Email is not set in settings table\n";
        echo "    Action: Go to Admin Panel → Settings → Set 'Orders Contact Email'\n";
    }
} catch (\Exception $e) {
    $errors[] = "❌ Error accessing settings table: " . $e->getMessage();
    echo "❌ Error accessing settings table: " . $e->getMessage() . "\n";
}

// Step 4: Test Email Send (Optional)
echo "\n📋 STEP 4: Testing Email Send\n";
echo "─────────────────────────────────────────────────────────────────\n";

if (count($errors) === 0) {
    echo "Attempting to send test email...\n\n";
    
    try {
        Mail::raw('This is a test email from Bijliwala Email Configuration Test.', function ($message) {
            $message
                ->to(env('MAIL_FROM_ADDRESS'))
                ->subject('🧪 Bijliwala Email Configuration Test');
        });
        
        echo "✅ TEST EMAIL SENT SUCCESSFULLY!\n";
        echo "   Check your inbox at: " . env('MAIL_FROM_ADDRESS') . "\n";
        echo "   Email should arrive within 1-2 minutes\n";
    } catch (\Exception $e) {
        echo "❌ Failed to send test email:\n";
        echo "   Error: " . $e->getMessage() . "\n";
        echo "\n   Possible causes:\n";
        echo "   1. Incorrect Gmail app password (check for spaces)\n";
        echo "   2. 2-Step Verification not enabled on Gmail\n";
        echo "   3. Gmail account has restricted access\n";
        echo "   4. Network/Firewall blocking SMTP connection\n";
    }
} else {
    echo "⚠️  Cannot test email send - configuration errors found.\n";
}

// Step 5: Summary
echo "\n📋 STEP 5: Summary\n";
echo "─────────────────────────────────────────────────────────────────\n";

if (count($errors) === 0) {
    echo "✅ ALL CHECKS PASSED!\n\n";
    echo "Your email configuration is ready to use:\n";
    echo "  • Gmail SMTP configured correctly\n";
    echo "  • Admin email is set in settings\n";
    echo "  • Email sending is enabled\n\n";
    echo "🎯 Next Steps:\n";
    echo "  1. Check your email inbox for the test email\n";
    echo "  2. Place a test order to verify order notifications\n";
    echo "  3. Check admin email for order notification\n";
} else {
    echo "❌ CONFIGURATION ERRORS FOUND:\n\n";
    foreach ($errors as $error) {
        echo "  • {$error}\n";
    }
    echo "\n📝 Please fix the above errors before testing.\n";
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║                    TEST COMPLETE                               ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";
