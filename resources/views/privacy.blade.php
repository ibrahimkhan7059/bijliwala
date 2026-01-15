@extends('layouts.frontend')

@section('title', 'Privacy Policy - ' . $siteSettings->site_name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-orange-50 py-8 md:py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Privacy Policy</h1>
            <p class="text-gray-600">Last updated: {{ date('F d, Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 lg:p-10">
            @if($siteSettings->privacy_policy)
                <!-- Admin-edited content -->
                <div class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-p:text-gray-700 prose-ul:text-gray-700 prose-ol:text-gray-700 prose-li:text-gray-700 prose-strong:text-gray-900 prose-a:text-blue-600 hover:prose-a:text-blue-800">
                    {!! $siteSettings->privacy_policy !!}
                </div>
            @else
                <!-- Default content -->
                <div class="space-y-6 md:space-y-8">
                    <!-- Introduction -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Introduction</h2>
                        <p class="text-gray-700 leading-relaxed">
                            Welcome to {{ $siteSettings->site_name }}. We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.
                        </p>
                    </section>

            <!-- Information We Collect -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Information We Collect</h2>
                <div class="space-y-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">2.1 Personal Information</h3>
                        <p class="text-gray-700 leading-relaxed">
                            We may collect personal information that you voluntarily provide to us when you:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 ml-4 mt-2 space-y-1">
                            <li>Register for an account</li>
                            <li>Place an order</li>
                            <li>Subscribe to our newsletter</li>
                            <li>Contact us for support</li>
                            <li>Participate in surveys or promotions</li>
                        </ul>
                        <p class="text-gray-700 leading-relaxed mt-3">
                            This information may include your name, email address, phone number, shipping address, billing address, and payment information.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">2.2 Automatically Collected Information</h3>
                        <p class="text-gray-700 leading-relaxed">
                            When you visit our website, we automatically collect certain information about your device, including:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 ml-4 mt-2 space-y-1">
                            <li>IP address</li>
                            <li>Browser type and version</li>
                            <li>Operating system</li>
                            <li>Pages visited and time spent on pages</li>
                            <li>Referring website addresses</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- How We Use Your Information -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">3. How We Use Your Information</h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    We use the information we collect for various purposes, including:
                </p>
                <ul class="list-disc list-inside text-gray-700 ml-4 space-y-2">
                    <li>Processing and fulfilling your orders</li>
                    <li>Communicating with you about your orders and account</li>
                    <li>Sending you marketing communications (with your consent)</li>
                    <li>Improving our website and services</li>
                    <li>Preventing fraud and ensuring security</li>
                    <li>Complying with legal obligations</li>
                    <li>Responding to your inquiries and support requests</li>
                </ul>
            </section>

            <!-- Information Sharing -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Information Sharing and Disclosure</h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    We do not sell, trade, or rent your personal information to third parties. We may share your information only in the following circumstances:
                </p>
                <ul class="list-disc list-inside text-gray-700 ml-4 space-y-2">
                    <li><strong>Service Providers:</strong> We may share information with trusted third-party service providers who assist us in operating our website, conducting business, or serving our customers.</li>
                    <li><strong>Legal Requirements:</strong> We may disclose your information if required by law or in response to valid requests by public authorities.</li>
                    <li><strong>Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets, your information may be transferred as part of that transaction.</li>
                </ul>
            </section>

            <!-- Data Security -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Data Security</h2>
                <p class="text-gray-700 leading-relaxed">
                    We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.
                </p>
            </section>

            <!-- Your Rights -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Your Rights</h2>
                <p class="text-gray-700 leading-relaxed mb-3">
                    You have the right to:
                </p>
                <ul class="list-disc list-inside text-gray-700 ml-4 space-y-2">
                    <li>Access and receive a copy of your personal information</li>
                    <li>Rectify inaccurate or incomplete information</li>
                    <li>Request deletion of your personal information</li>
                    <li>Object to processing of your personal information</li>
                    <li>Request restriction of processing</li>
                    <li>Data portability</li>
                    <li>Withdraw consent at any time</li>
                </ul>
            </section>

            <!-- Cookies -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Cookies and Tracking Technologies</h2>
                <p class="text-gray-700 leading-relaxed">
                    We use cookies and similar tracking technologies to track activity on our website and store certain information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our website.
                </p>
            </section>

            <!-- Third-Party Links -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Third-Party Links</h2>
                <p class="text-gray-700 leading-relaxed">
                    Our website may contain links to third-party websites. We are not responsible for the privacy practices or content of these external sites. We encourage you to review the privacy policies of any third-party sites you visit.
                </p>
            </section>

            <!-- Children's Privacy -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Children's Privacy</h2>
                <p class="text-gray-700 leading-relaxed">
                    Our services are not directed to individuals under the age of 18. We do not knowingly collect personal information from children. If you become aware that a child has provided us with personal information, please contact us, and we will take steps to delete such information.
                </p>
            </section>

            <!-- Changes to Privacy Policy -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Changes to This Privacy Policy</h2>
                <p class="text-gray-700 leading-relaxed">
                    We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date. You are advised to review this Privacy Policy periodically for any changes.
                </p>
            </section>

                    <!-- Contact Us -->
                    <section class="bg-gradient-to-r from-orange-50 to-amber-50 p-6 rounded-xl">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Contact Us</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            If you have any questions about this Privacy Policy, please contact us:
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

