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
                
                <button @click="activeTab = 'privacy-terms'"
                        :class="activeTab === 'privacy-terms' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm transition-colors">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Privacy & Terms
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
                                        <strong>📏 Size:</strong> Max 2MB | <strong>✅ Best:</strong> 200x200px (square) | <strong>🎨 Format:</strong> PNG recommended for transparency
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
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       placeholder="+92-300-1234567">
                            </div>

                            <!-- WhatsApp Number -->
                            <div>
                                <label for="site_whatsapp" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline-block mr-1 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                    WhatsApp Number (General)
                                </label>
                                <input type="text" 
                                       name="site_whatsapp" 
                                       id="site_whatsapp" 
                                       value="{{ old('site_whatsapp', $settings['site_whatsapp'] ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                       placeholder="923001234567">
                                <p class="mt-1 text-xs text-gray-500">Enter number with country code (e.g., 923001234567)</p>
                            </div>

                            <!-- Separate Contact Numbers -->
                            <div class="col-span-2">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">
                                    <svg class="w-5 h-5 inline-block mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    Separate Contact Information
                                </h3>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <!-- Solar Installations & Sponsorships -->
                                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                        <h4 class="font-semibold text-green-800 mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            For Solar Installations & Brand Sponsorships
                                        </h4>
                                        
                                        <div class="space-y-3">
                                            <div>
                                                <label for="solar_contact_whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
                                                <input type="text" 
                                                       name="solar_contact_whatsapp" 
                                                       id="solar_contact_whatsapp" 
                                                       value="{{ old('solar_contact_whatsapp', $settings['solar_contact_whatsapp'] ?? '') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                       placeholder="+92 311 6745016">
                                            </div>
                                            
                                            <div>
                                                <label for="solar_contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                                <input type="email" 
                                                       name="solar_contact_email" 
                                                       id="solar_contact_email" 
                                                       value="{{ old('solar_contact_email', $settings['solar_contact_email'] ?? '') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                       placeholder="solar@ajelectric.es">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product Orders -->
                                    <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                                        <h4 class="font-semibold text-orange-800 mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            For Product Orders Only
                                        </h4>
                                        
                                        <div class="space-y-3">
                                            <div>
                                                <label for="orders_contact_whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
                                                <input type="text" 
                                                       name="orders_contact_whatsapp" 
                                                       id="orders_contact_whatsapp" 
                                                       value="{{ old('orders_contact_whatsapp', $settings['orders_contact_whatsapp'] ?? '') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                                       placeholder="+92 331 5346889">
                                            </div>
                                            
                                            <div>
                                                <label for="orders_contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                                <input type="email" 
                                                       name="orders_contact_email" 
                                                       id="orders_contact_email" 
                                                       value="{{ old('orders_contact_email', $settings['orders_contact_email'] ?? '') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                                       placeholder="sales@ajelectric.es">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Business Location -->
                            <div>
                                <label for="business_location" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline-block mr-1 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Business Location
                                </label>
                                <input type="text" 
                                       name="business_location" 
                                       id="business_location" 
                                       value="{{ old('business_location', $settings['business_location'] ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200"
                                       placeholder="Wah Cantt, Pakistan">
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

                        <!-- Delivery Charges -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="delivery_charges" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Delivery Charges (Rs.) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                    
                                    </div>
                                    <input type="number" 
                                           name="delivery_charges" 
                                           id="delivery_charges" 
                                           value="{{ old('delivery_charges', $settings['delivery_charges'] ?? 250) }}"
                                           min="0"
                                           step="1"
                                           class="w-full pl-16 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-base"
                                           required>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Delivery charges applied to all orders</p>
                            </div>
                        </div>

                        <!-- Bank Details -->
                        <div class="mt-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                            <div class="flex items-center mb-4">
                                <div class="p-2 bg-green-100 rounded-lg mr-3">
                                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Bank Account Details</h3>
                                    <p class="text-sm text-gray-600">Add bank details for customer payments (displayed on cart page)</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Bank Name -->
                                <div>
                                    <label for="bank_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Bank Name
                                    </label>
                                    <input type="text" 
                                           name="bank_name" 
                                           id="bank_name" 
                                           value="{{ old('bank_name', $settings['bank_name'] ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                           placeholder="e.g., HBL, UBL, Meezan Bank">
                                </div>

                                <!-- Account Number -->
                                <div>
                                    <label for="account_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                        Account Number / IBAN
                                    </label>
                                    <input type="text" 
                                           name="account_number" 
                                           id="account_number" 
                                           value="{{ old('account_number', $settings['account_number'] ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                           placeholder="e.g., PK36HABB0000001234567890">
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        <div class="mt-8 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-200">
                            <div class="flex items-center mb-4">
                                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                    <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Social Media Links</h3>
                                    <p class="text-sm text-gray-600">Add your social media profiles (optional)</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Facebook -->
                                <div>
                                    <label for="social_facebook" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                        Facebook URL
                                    </label>
                                    <input type="url" 
                                           name="social_facebook" 
                                           id="social_facebook" 
                                           value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                           placeholder="https://facebook.com/yourpage">
                                </div>

                                <!-- Instagram -->
                                <div>
                                    <label for="social_instagram" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                        Instagram URL
                                    </label>
                                    <input type="url" 
                                           name="social_instagram" 
                                           id="social_instagram" 
                                           value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-colors duration-200"
                                           placeholder="https://instagram.com/yourprofile">
                                </div>

                                <!-- TikTok -->
                                <div>
                                    <label for="social_tiktok" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.18 6.18 0 0 0-1-.05A6.18 6.18 0 0 0 5 20.1a6.18 6.18 0 0 0 10.86-4.43v-7a8.28 8.28 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                        </svg>
                                        TikTok URL
                                    </label>
                                    <input type="url" 
                                           name="social_tiktok" 
                                           id="social_tiktok" 
                                           value="{{ old('social_tiktok', $settings['social_tiktok'] ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200"
                                           placeholder="https://tiktok.com/@yourprofile">
                                </div>

                                <!-- YouTube -->
                                <div>
                                    <label for="social_youtube" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                        YouTube URL
                                    </label>
                                    <input type="url" 
                                           name="social_youtube" 
                                           id="social_youtube" 
                                           value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200"
                                           placeholder="https://youtube.com/@yourchannel">
                                </div>

                                <!-- Twitter -->
                                <div>
                                    <label for="social_twitter" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                        Twitter URL
                                    </label>
                                    <input type="url" 
                                           name="social_twitter" 
                                           id="social_twitter" 
                                           value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-colors duration-200"
                                           placeholder="https://twitter.com/yourprofile">
                                </div>
                            </div>
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

            <!-- Privacy & Terms Tab -->
            <div x-show="activeTab === 'privacy-terms'" x-transition>
                <form method="POST" action="{{ route('admin.settings.privacy-terms') }}">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="flex items-center mb-6">
                            <div class="p-2 bg-green-100 rounded-lg mr-3">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Privacy Policy & Terms of Service</h3>
                                <p class="text-sm text-gray-600">Manage privacy policy and terms of service content</p>
                            </div>
                        </div>

                        <!-- Privacy Policy Editor -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200 p-4 sm:p-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <svg class="w-5 h-5 inline-block mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Privacy Policy Content
                            </label>
                            <textarea name="privacy_policy" 
                                      id="privacy_policy" 
                                      rows="15"
                                      class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono"
                                      placeholder="Enter Privacy Policy content here...">{{ old('privacy_policy', $settings['privacy_policy'] ?? '') }}</textarea>
                            <p class="mt-2 text-xs text-gray-500">You can use HTML tags for formatting. This content will be displayed on the Privacy Policy page.</p>
                        </div>

                        <!-- Terms of Service Editor -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200 p-4 sm:p-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <svg class="w-5 h-5 inline-block mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Terms of Service Content
                            </label>
                            <textarea name="terms_of_service" 
                                      id="terms_of_service" 
                                      rows="15"
                                      class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 font-mono"
                                      placeholder="Enter Terms of Service content here...">{{ old('terms_of_service', $settings['terms_of_service'] ?? '') }}</textarea>
                            <p class="mt-2 text-xs text-gray-500">You can use HTML tags for formatting. This content will be displayed on the Terms of Service page.</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4 border-t border-gray-200">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Privacy & Terms
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
