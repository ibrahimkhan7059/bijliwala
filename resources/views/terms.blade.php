@extends('layouts.frontend')

@section('title', 'Terms of Service - ' . $siteSettings->site_name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-orange-50 py-8 md:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Terms of Service</h1>
            <p class="text-gray-600">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 lg:p-10">
            @if($siteSettings->terms_of_service)
                <!-- Admin-edited content -->
                <div class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-p:text-gray-700 prose-ul:text-gray-700 prose-ol:text-gray-700 prose-li:text-gray-700 prose-strong:text-gray-900 prose-a:text-blue-600 hover:prose-a:text-blue-800">
                    {!! $siteSettings->terms_of_service !!}
                </div>
            @else
                <!-- Default content -->
                <div class="space-y-6 md:space-y-8">
                    <!-- Introduction -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Agreement to Terms</h2>
                        <p class="text-gray-700 leading-relaxed">
                            By accessing and using {{ $siteSettings->site_name }} website and services, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
                        </p>
                    </section>

            <!-- Use License -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Use License</h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    Permission is granted to temporarily access the materials on {{ $siteSettings->site_name }}'s website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
                </p>
                <ul class="list-disc list-inside text-gray-700 ml-4 space-y-2">
                    <li>Modify or copy the materials</li>
                    <li>Use the materials for any commercial purpose or for any public display</li>
                    <li>Attempt to reverse engineer any software contained on the website</li>
                    <li>Remove any copyright or other proprietary notations from the materials</li>
                    <li>Transfer the materials to another person or "mirror" the materials on any other server</li>
                </ul>
            </section>

            <!-- Products and Services -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Products and Services</h2>
                <div class="space-y-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">3.1 Product Information</h3>
                        <p class="text-gray-700 leading-relaxed">
                            We strive to provide accurate product descriptions, images, and pricing. However, we do not warrant that product descriptions or other content on this site is accurate, complete, reliable, current, or error-free.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">3.2 Pricing</h3>
                        <p class="text-gray-700 leading-relaxed">
                            All prices are displayed in Pakistani Rupees (PKR) and are subject to change without notice. We reserve the right to modify prices at any time. In the event of a pricing error, we reserve the right to cancel any orders placed at the incorrect price.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">3.3 Availability</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Product availability is subject to change. We reserve the right to discontinue any product at any time. If a product becomes unavailable after you place an order, we will notify you and provide a refund or alternative solution.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Orders and Payment -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Orders and Payment</h2>
                <div class="space-y-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">4.1 Order Acceptance</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Your order is an offer to purchase products from us. We reserve the right to accept or reject your order for any reason, including product availability, errors in pricing or product information, or suspected fraud.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">4.2 Payment Terms</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Payment must be made in full at the time of order placement. We accept bank transfers and other payment methods as specified on our website. You agree to provide current, complete, and accurate purchase and account information for all purchases.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">4.3 Payment Proof</h3>
                        <p class="text-gray-700 leading-relaxed">
                            For bank transfer orders, you must upload a payment proof screenshot. Orders will be processed only after payment verification. We reserve the right to cancel orders if payment is not verified within 24 hours.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Shipping and Delivery -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Shipping and Delivery</h2>
                <div class="space-y-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">5.1 Delivery Time</h3>
                        <p class="text-gray-700 leading-relaxed">
                            We aim to deliver products within 3-5 business days. Delivery times are estimates and not guaranteed. Factors such as weather, holidays, or unforeseen circumstances may affect delivery times.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">5.2 Delivery Charges</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Delivery charges are calculated and displayed at checkout. Delivery charges are non-refundable unless the order is cancelled by us.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">5.3 Risk of Loss</h3>
                        <p class="text-gray-700 leading-relaxed">
                            All items purchased from us are made pursuant to a shipment contract. This means that the risk of loss and title for such items pass to you upon our delivery to the carrier.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Returns and Refunds -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Returns and Refunds</h2>
                <div class="space-y-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">6.1 Return Policy</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Products may be returned within 7 days of delivery if they are defective, damaged, or not as described. Items must be in their original packaging and unused condition. Custom or personalized items may not be eligible for return.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">6.2 Refund Process</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Refunds will be processed to the original payment method within 5-10 business days after we receive and inspect the returned item. Delivery charges are non-refundable unless the return is due to our error.
                        </p>
                    </div>
                </div>
            </section>

            <!-- User Accounts -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">7. User Accounts</h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    When you create an account with us, you must provide information that is accurate, complete, and current at all times. You are responsible for:
                </p>
                <ul class="list-disc list-inside text-gray-700 ml-4 space-y-2">
                    <li>Maintaining the security of your account and password</li>
                    <li>All activities that occur under your account</li>
                    <li>Notifying us immediately of any unauthorized use</li>
                    <li>Ensuring that your account information is kept up to date</li>
                </ul>
            </section>

            <!-- Prohibited Uses -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Prohibited Uses</h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    You may not use our website:
                </p>
                <ul class="list-disc list-inside text-gray-700 ml-4 space-y-2">
                    <li>In any way that violates any applicable law or regulation</li>
                    <li>To transmit any malicious code or viruses</li>
                    <li>To attempt to gain unauthorized access to any part of the website</li>
                    <li>To interfere with or disrupt the website or servers</li>
                    <li>To impersonate or attempt to impersonate another user or entity</li>
                    <li>For any fraudulent or illegal purpose</li>
                </ul>
            </section>

            <!-- Intellectual Property -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Intellectual Property</h2>
                <p class="text-gray-700 leading-relaxed">
                    The website and its original content, features, and functionality are owned by {{ $siteSettings->site_name }} and are protected by international copyright, trademark, patent, trade secret, and other intellectual property laws.
                </p>
            </section>

            <!-- Limitation of Liability -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Limitation of Liability</h2>
                <p class="text-gray-700 leading-relaxed">
                    In no event shall {{ $siteSettings->site_name }}, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from your use of the website or services.
                </p>
            </section>

            <!-- Indemnification -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Indemnification</h2>
                <p class="text-gray-700 leading-relaxed">
                    You agree to defend, indemnify, and hold harmless {{ $siteSettings->site_name }} and its licensee and licensors, and their employees, contractors, agents, officers and directors, from and against any and all claims, damages, obligations, losses, liabilities, costs or debt, and expenses (including but not limited to attorney's fees).
                </p>
            </section>

            <!-- Governing Law -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">12. Governing Law</h2>
                <p class="text-gray-700 leading-relaxed">
                    These Terms shall be interpreted and governed by the laws of Pakistan, without regard to its conflict of law provisions. Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights.
                </p>
            </section>

            <!-- Changes to Terms -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">13. Changes to Terms</h2>
                <p class="text-gray-700 leading-relaxed">
                    We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material, we will provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.
                </p>
            </section>

                    <!-- Contact Information -->
                    <section class="bg-gradient-to-r from-orange-50 to-amber-50 p-6 rounded-xl">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">14. Contact Information</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            If you have any questions about these Terms of Service, please contact us:
                        </p>
                        <div class="space-y-2 text-gray-700">
                            <p><strong>Email:</strong> {{ $siteSettings->site_email }}</p>
                            <p><strong>Phone:</strong> {{ $siteSettings->site_phone }}</p>
                            <p><strong>Address:</strong> {{ $siteSettings->site_address }}</p>
                        </div>
                    </section>
                </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold rounded-lg hover:from-orange-600 hover:to-amber-600 transition-all shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection

