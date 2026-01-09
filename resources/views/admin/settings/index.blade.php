@extends('admin.layout')

@section('title', 'Settings')
@section('page-title', 'System Settings')

@section('content')
<div class="animate-fade-in max-w-full overflow-hidden">
    <!-- Professional Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6 animate-slide-in-down">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">System Settings</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Manage application configuration and preferences</p>
                </div>
            </div>
            <div class="flex gap-3">
                <!-- Backup Button -->
                <form method="POST" action="{{ route('admin.settings.backup-database') }}" class="inline w-full sm:w-auto">
                    @csrf
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 text-white text-xs sm:text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent"
                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);"
                            onclick="return confirm('Create database backup? This may take a few moments.')">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        <span class="hidden sm:inline">Backup Database</span>
                        <span class="sm:hidden">Backup</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Settings Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-slide-in-up" x-data="{ activeTab: 'general' }">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 overflow-x-auto">
            <nav class="flex space-x-4 sm:space-x-8 px-4 sm:px-6" aria-label="Tabs">
                <button @click="activeTab = 'general'"
                        :class="activeTab === 'general' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-colors">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                    General Settings
                </button>
                
                <button @click="activeTab = 'email'"
                        :class="activeTab === 'email' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-colors">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Email Settings
                </button>
                
                <button @click="activeTab = 'security'"
                        :class="activeTab === 'security' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-colors">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Security
                </button>
                
                <button @click="activeTab = 'system'"
                        :class="activeTab === 'system' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-colors">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                    System Info
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-4 sm:p-6">
            <!-- General Settings Tab -->
            <div x-show="activeTab === 'general'" x-transition>
                <form method="POST" action="{{ route('admin.settings.general') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">General Configuration</h3>
                                <p class="text-sm text-gray-600">Basic website information and settings</p>
                            </div>
                        </div>

                        <!-- Site Logo Upload -->
                        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <svg class="w-5 h-5 inline-block mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Site Logo
                            </label>
                            
                            <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                                <!-- Current Logo Preview -->
                                <div class="flex-shrink-0">
                                    <div class="w-24 h-24 rounded-lg border-2 border-gray-300 overflow-hidden bg-white shadow-sm">
                                        <img id="logoPreview" 
                                             src="{{ $settings['site_logo'] ? asset('storage/' . $settings['site_logo']) . '?v=' . time() : asset('images/logo.avif') }}" 
                                             alt="Current Logo" 
                                             class="w-full h-full object-contain p-2">
                                    </div>
                                </div>
                                
                                <!-- Upload Input -->
                                <div class="flex-1">
                                    <input type="file" 
                                           name="site_logo" 
                                           id="site_logo" 
                                           accept="image/jpeg,image/jpg,image/png,image/webp,image/avif"
                                           class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-gray-300 rounded-lg"
                                           onchange="previewLogo(event)">
                                    <p class="mt-2 text-xs text-gray-500">
                                        Upload a logo (JPG, PNG, WEBP, AVIF). Recommended size: 200x200px
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Site Name -->
                            <div>
                                <label for="site_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Site Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="site_name" 
                                       id="site_name" 
                                       value="{{ old('site_name', $settings['site_name']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       required>
                            </div>

                            <!-- Site Email -->
                            <div>
                                <label for="site_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Site Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="site_email" 
                                       id="site_email" 
                                       value="{{ old('site_email', $settings['site_email']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       required>
                            </div>

                            <!-- Site Phone -->
                            <div>
                                <label for="site_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Site Phone
                                </label>
                                <input type="text" 
                                       name="site_phone" 
                                       id="site_phone" 
                                       value="{{ old('site_phone', $settings['site_phone']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            </div>

                            <!-- Currency -->
                            <div>
                                <label for="currency" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Currency <span class="text-red-500">*</span>
                                </label>
                                <select name="currency" 
                                        id="currency"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        required>
                                    <option value="PKR" {{ $settings['currency'] == 'PKR' ? 'selected' : '' }}>Pakistani Rupee (PKR)</option>
                                    <option value="USD" {{ $settings['currency'] == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                                    <option value="EUR" {{ $settings['currency'] == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                </select>
                            </div>

                            <!-- Currency Symbol -->
                            <div>
                                <label for="currency_symbol" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Currency Symbol <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="currency_symbol" 
                                       id="currency_symbol" 
                                       value="{{ old('currency_symbol', $settings['currency_symbol']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       required>
                            </div>

                            <!-- Timezone -->
                            <div>
                                <label for="timezone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Timezone <span class="text-red-500">*</span>
                                </label>
                                <select name="timezone" 
                                        id="timezone"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        required>
                                    <option value="Asia/Karachi" {{ $settings['timezone'] == 'Asia/Karachi' ? 'selected' : '' }}>Asia/Karachi</option>
                                    <option value="Asia/Dubai" {{ $settings['timezone'] == 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai</option>
                                    <option value="UTC" {{ $settings['timezone'] == 'UTC' ? 'selected' : '' }}>UTC</option>
                                </select>
                            </div>

                            <!-- Date Format -->
                            <div>
                                <label for="date_format" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Date Format <span class="text-red-500">*</span>
                                </label>
                                <select name="date_format" 
                                        id="date_format"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        required>
                                    <option value="Y-m-d" {{ $settings['date_format'] == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                    <option value="d/m/Y" {{ $settings['date_format'] == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                    <option value="m/d/Y" {{ $settings['date_format'] == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                </select>
                            </div>

                            <!-- Items Per Page -->
                            <div>
                                <label for="items_per_page" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Items Per Page <span class="text-red-500">*</span>
                                </label>
                                <select name="items_per_page" 
                                        id="items_per_page"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        required>
                                    <option value="10" {{ $settings['items_per_page'] == '10' ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $settings['items_per_page'] == '25' ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $settings['items_per_page'] == '50' ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $settings['items_per_page'] == '100' ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        </div>

                        <!-- Site Address -->
                        <div>
                            <label for="site_address" class="block text-sm font-semibold text-gray-700 mb-2">
                                Site Address
                            </label>
                            <textarea name="site_address" 
                                      id="site_address" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                      placeholder="Enter complete address">{{ old('site_address', $settings['site_address']) }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent"
                                    style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Update General Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Email Settings Tab -->
            <div x-show="activeTab === 'email'" x-transition>
                <form method="POST" action="{{ route('admin.settings.email') }}">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-green-100 rounded-lg mr-3">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Email Configuration</h3>
                                <p class="text-sm text-gray-600">SMTP and email delivery settings</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Mail Driver -->
                            <div>
                                <label for="mail_driver" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Mail Driver <span class="text-red-500">*</span>
                                </label>
                                <select name="mail_driver" 
                                        id="mail_driver"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        required>
                                    <option value="smtp" {{ $settings['mail_driver'] == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                    <option value="sendmail" {{ $settings['mail_driver'] == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                    <option value="log" {{ $settings['mail_driver'] == 'log' ? 'selected' : '' }}>Log (Testing)</option>
                                </select>
                            </div>

                            <!-- Mail Host -->
                            <div>
                                <label for="mail_host" class="block text-sm font-semibold text-gray-700 mb-2">
                                    SMTP Host <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="mail_host" 
                                       id="mail_host" 
                                       value="{{ old('mail_host', $settings['mail_host']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       placeholder="smtp.gmail.com">
                            </div>

                            <!-- Mail Port -->
                            <div>
                                <label for="mail_port" class="block text-sm font-semibold text-gray-700 mb-2">
                                    SMTP Port <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="mail_port" 
                                       id="mail_port" 
                                       value="{{ old('mail_port', $settings['mail_port']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       placeholder="587">
                            </div>

                            <!-- Mail Username -->
                            <div>
                                <label for="mail_username" class="block text-sm font-semibold text-gray-700 mb-2">
                                    SMTP Username <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="mail_username" 
                                       id="mail_username" 
                                       value="{{ old('mail_username', $settings['mail_username']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       placeholder="your-email@gmail.com">
                            </div>

                            <!-- Mail Password -->
                            <div>
                                <label for="mail_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    SMTP Password
                                </label>
                                <input type="password" 
                                       name="mail_password" 
                                       id="mail_password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       placeholder="Leave blank to keep current password">
                                <p class="text-sm text-gray-500 mt-1">Leave blank to keep current password</p>
                            </div>

                            <!-- Mail Encryption -->
                            <div>
                                <label for="mail_encryption" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Encryption
                                </label>
                                <select name="mail_encryption" 
                                        id="mail_encryption"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="">None</option>
                                    <option value="tls" {{ $settings['mail_encryption'] == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ $settings['mail_encryption'] == 'ssl' ? 'selected' : '' }}>SSL</option>
                                </select>
                            </div>

                            <!-- From Address -->
                            <div>
                                <label for="mail_from_address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    From Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="mail_from_address" 
                                       id="mail_from_address" 
                                       value="{{ old('mail_from_address', $settings['mail_from_address']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       required>
                            </div>

                            <!-- From Name -->
                            <div>
                                <label for="mail_from_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    From Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="mail_from_name" 
                                       id="mail_from_name" 
                                       value="{{ old('mail_from_name', $settings['mail_from_name']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       required>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent"
                                    style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Update Email Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Security Settings Tab -->
            <div x-show="activeTab === 'security'" x-transition>
                <form method="POST" action="{{ route('admin.settings.security') }}">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-red-100 rounded-lg mr-3">
                                <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Security Configuration</h3>
                                <p class="text-sm text-gray-600">Authentication and security settings</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Session Lifetime -->
                            <div>
                                <label for="session_lifetime" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Session Lifetime (minutes) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="session_lifetime" 
                                       id="session_lifetime" 
                                       value="{{ old('session_lifetime', $settings['session_lifetime']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       min="60" max="10080" required>
                                <p class="text-sm text-gray-500 mt-1">How long users stay logged in (60-10080 minutes)</p>
                            </div>

                            <!-- Password Min Length -->
                            <div>
                                <label for="password_min_length" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Minimum Password Length <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="password_min_length" 
                                       id="password_min_length" 
                                       value="{{ old('password_min_length', $settings['password_min_length']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       min="6" max="50" required>
                                <p class="text-sm text-gray-500 mt-1">Minimum characters required for passwords</p>
                            </div>

                            <!-- Login Attempts -->
                            <div>
                                <label for="login_attempts" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Max Login Attempts <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="login_attempts" 
                                       id="login_attempts" 
                                       value="{{ old('login_attempts', $settings['login_attempts']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       min="3" max="10" required>
                                <p class="text-sm text-gray-500 mt-1">Failed attempts before account lockout</p>
                            </div>

                            <!-- Lockout Duration -->
                            <div>
                                <label for="lockout_duration" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Lockout Duration (minutes) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="lockout_duration" 
                                       id="lockout_duration" 
                                       value="{{ old('lockout_duration', $settings['lockout_duration']) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       min="1" max="60" required>
                                <p class="text-sm text-gray-500 mt-1">How long accounts are locked after max attempts</p>
                            </div>
                        </div>

                        <!-- Security Options -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-gray-900">Security Options</h4>
                            
                            <!-- Email Verification -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5 mt-1">
                                    <input id="require_email_verification" 
                                           name="require_email_verification" 
                                           type="checkbox" 
                                           value="1"
                                           {{ $settings['require_email_verification'] ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </div>
                                <div class="ml-3">
                                    <label for="require_email_verification" class="text-sm font-semibold text-gray-700">
                                        Require Email Verification
                                    </label>
                                    <p class="text-sm text-gray-500">New users must verify their email before accessing the system</p>
                                </div>
                            </div>

                            <!-- Two Factor Authentication -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5 mt-1">
                                    <input id="enable_2fa" 
                                           name="enable_2fa" 
                                           type="checkbox" 
                                           value="1"
                                           {{ $settings['enable_2fa'] ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </div>
                                <div class="ml-3">
                                    <label for="enable_2fa" class="text-sm font-semibold text-gray-700">
                                        Enable Two-Factor Authentication
                                    </label>
                                    <p class="text-sm text-gray-500">Users can enable 2FA for additional security</p>
                                </div>
                            </div>

                            <!-- Maintenance Mode -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5 mt-1">
                                    <input id="maintenance_mode" 
                                           name="maintenance_mode" 
                                           type="checkbox" 
                                           value="1"
                                           {{ $settings['maintenance_mode'] ? 'checked' : '' }}
                                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                </div>
                                <div class="ml-3">
                                    <label for="maintenance_mode" class="text-sm font-semibold text-gray-700">
                                        Maintenance Mode
                                    </label>
                                    <p class="text-sm text-gray-500 text-red-600">⚠️ This will take the site offline for regular users</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent"
                                    style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Update Security Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- System Info Tab -->
            <div x-show="activeTab === 'system'" x-transition>
                <div class="space-y-6">
                    <!-- System Information -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">System Information</h3>
                                <p class="text-sm text-gray-600">Server and application details</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-3">Server Information</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">PHP Version:</span>
                                        <span class="font-medium">{{ $systemInfo['php_version'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Laravel Version:</span>
                                        <span class="font-medium">{{ $systemInfo['laravel_version'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Server Software:</span>
                                        <span class="font-medium">{{ $systemInfo['server_software'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Database Version:</span>
                                        <span class="font-medium">{{ $systemInfo['database_version'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-3">PHP Configuration</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Memory Limit:</span>
                                        <span class="font-medium">{{ $systemInfo['memory_limit'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Max Execution Time:</span>
                                        <span class="font-medium">{{ $systemInfo['max_execution_time'] }}s</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Upload Max Size:</span>
                                        <span class="font-medium">{{ $systemInfo['upload_max_filesize'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Storage Used:</span>
                                        <span class="font-medium">{{ $systemInfo['storage_used'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cache Management -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                                <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Cache Management</h3>
                                <p class="text-sm text-gray-600">Clear application caches for better performance</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-3">Cache Status</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Configuration Cache:</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cacheInfo['config_cached'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $cacheInfo['config_cached'] ? 'Cached' : 'Not Cached' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Routes Cache:</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cacheInfo['routes_cached'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $cacheInfo['routes_cached'] ? 'Cached' : 'Not Cached' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Views Cache:</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cacheInfo['views_cached'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $cacheInfo['views_cached'] ? 'Cached' : 'Not Cached' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Cache Driver:</span>
                                        <span class="font-medium">{{ $cacheInfo['cache_driver'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-3">Quick Actions</h4>
                                <div class="space-y-3">
                                    <form method="POST" action="{{ route('admin.settings.clear-cache') }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="type" value="all">
                                        <button type="submit" 
                                                class="w-full inline-flex justify-center items-center px-4 py-2 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent"
                                                style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);"
                                                onclick="return confirm('Clear all caches? This may temporarily slow down the application.')">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Clear All Cache
                                        </button>
                                    </form>

                                    <div class="grid grid-cols-2 gap-2">
                                        <form method="POST" action="{{ route('admin.settings.clear-cache') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="type" value="config">
                                            <button type="submit" class="w-full px-3 py-2 text-xs font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors">
                                                Config
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.settings.clear-cache') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="type" value="route">
                                            <button type="submit" class="w-full px-3 py-2 text-xs font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors">
                                                Routes
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.settings.clear-cache') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="type" value="view">
                                            <button type="submit" class="w-full px-3 py-2 text-xs font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors">
                                                Views
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.settings.clear-cache') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="type" value="application">
                                            <button type="submit" class="w-full px-3 py-2 text-xs font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors">
                                                App Cache
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Logo Preview Function
function previewLogo(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logoPreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>

@endsection
