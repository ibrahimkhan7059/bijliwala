@extends('layouts.frontend')

@section('title', 'Profile Settings')

@push('styles')
<style>
    .profile-gradient {
        background: linear-gradient(135deg, #fff5e6 0%, #ffe4c4 25%, #ffd7a8 50%, #ffedd5 75%, #fff5e6 100%);
        background-attachment: fixed;
    }
    .tab-active {
        background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
        color: white;
    }
    .tab-inactive {
        color: #6b7280;
    }
    .tab-inactive:hover {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
</style>
@endpush

@section('content')
<div class="profile-gradient min-h-screen py-4 md:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Profile Header -->
        <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-amber-200/50 p-4 md:p-6 mb-4 md:mb-6">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 md:gap-6 w-full md:w-auto">
                    <!-- Avatar - Name First Letter Only -->
                    <div class="relative">
                            <div class="h-16 w-16 md:h-20 md:w-20 rounded-full bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 flex items-center justify-center border-4 border-amber-300 shadow-lg">
                            <span class="text-xl md:text-2xl font-bold text-white uppercase">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                    </div>
                    
                    <div class="flex-1">
                        <h1 class="text-xl md:text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">{{ $user->name }}</h1>
                        <p class="text-sm md:text-base text-gray-600 mt-1">{{ $user->email }}</p>
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-300">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Verified
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-300">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.665-.833-2.464 0L4.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    Not Verified
                                </span>
                            @endif
                            
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-amber-100 to-orange-100 text-amber-800 border border-amber-300">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($orderStats)
                    <div class="text-left md:text-right w-full md:w-auto">
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-3 md:p-4 border border-amber-200">
                            <div class="text-xs md:text-sm text-gray-600 font-medium">Account Stats</div>
                            <div class="text-xl md:text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">{{ $orderStats['total_orders'] }}</div>
                            <div class="text-xs md:text-sm text-gray-600">Total Orders</div>
                            <div class="text-base md:text-lg font-semibold text-green-600 mt-1">PKR {{ number_format($orderStats['total_spent'], 2) }}</div>
                            <div class="text-xs text-gray-500">Total Spent</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-amber-200/50 overflow-hidden" x-data="{ activeTab: 'profile' }">
            <!-- Tab Navigation -->
            <div class="border-b-2 border-amber-200/50 bg-gradient-to-r from-amber-50/50 to-orange-50/50">
                <nav class="flex flex-wrap gap-2 md:gap-0 md:space-x-2 px-2 md:px-6 overflow-x-auto" aria-label="Tabs">
                    <button @click="activeTab = 'profile'"
                            :class="activeTab === 'profile' ? 'tab-active' : 'tab-inactive'"
                            class="whitespace-nowrap py-3 md:py-4 px-2 md:px-4 border-b-2 font-semibold text-xs md:text-sm transition-all rounded-t-lg md:rounded-t-none border-transparent md:border-b-2">
                        <svg class="w-4 h-4 md:w-5 md:h-5 inline-block mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="hidden sm:inline">Profile</span>
                        <span class="sm:hidden">Info</span>
                    </button>
                    
                    <button @click="activeTab = 'security'"
                            :class="activeTab === 'security' ? 'tab-active' : 'tab-inactive'"
                            class="whitespace-nowrap py-3 md:py-4 px-2 md:px-4 border-b-2 font-semibold text-xs md:text-sm transition-all rounded-t-lg md:rounded-t-none border-transparent md:border-b-2">
                        <svg class="w-4 h-4 md:w-5 md:h-5 inline-block mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Security
                    </button>
                    
                    <button @click="activeTab = 'preferences'"
                            :class="activeTab === 'preferences' ? 'tab-active' : 'tab-inactive'"
                            class="whitespace-nowrap py-3 md:py-4 px-2 md:px-4 border-b-2 font-semibold text-xs md:text-sm transition-all rounded-t-lg md:rounded-t-none border-transparent md:border-b-2">
                        <svg class="w-4 h-4 md:w-5 md:h-5 inline-block mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="hidden sm:inline">Preferences</span>
                        <span class="sm:hidden">Prefs</span>
                    </button>
                    
                    @if($orderStats)
                    <button @click="activeTab = 'orders'"
                            :class="activeTab === 'orders' ? 'tab-active' : 'tab-inactive'"
                            class="whitespace-nowrap py-3 md:py-4 px-2 md:px-4 border-b-2 font-semibold text-xs md:text-sm transition-all rounded-t-lg md:rounded-t-none border-transparent md:border-b-2">
                        <svg class="w-4 h-4 md:w-5 md:h-5 inline-block mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <span class="hidden sm:inline">My Orders</span>
                        <span class="sm:hidden">Orders</span>
                    </button>
                    @endif
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-4 md:p-6">
                <!-- Profile Information Tab -->
                <div x-show="activeTab === 'profile'" x-transition>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="space-y-6">
                            <div class="flex items-center mb-4 md:mb-6">
                                <div class="p-2 bg-gradient-to-br from-amber-100 to-orange-100 rounded-lg mr-3">
                                    <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base md:text-lg font-semibold text-gray-900">Personal Information</h3>
                                    <p class="text-xs md:text-sm text-gray-600">Update your personal details</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <!-- Full Name -->
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name', $user->name) }}"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('name') border-red-500 @enderror"
                                           required>
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           value="{{ old('email', $user->email) }}"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('email') border-red-500 @enderror"
                                           required>
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Phone Number
                                    </label>
                                    <input type="text" 
                                           name="phone" 
                                           id="phone" 
                                           value="{{ old('phone', $user->phone) }}"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200"
                                           placeholder="+92-300-1234567">
                                </div>

                                <!-- Role (Read-only) -->
                                <div>
                                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Account Type
                                    </label>
                                    <input type="text" 
                                           id="role" 
                                           value="{{ ucfirst($user->role) }}"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg bg-gradient-to-r from-amber-50 to-orange-50 text-gray-600 font-medium"
                                           readonly>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                        style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Security Tab -->
                <div x-show="activeTab === 'security'" x-transition>
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="space-y-6">
                            <div class="flex items-center mb-4 md:mb-6">
                                <div class="p-2 bg-gradient-to-br from-red-100 to-orange-100 rounded-lg mr-3">
                                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base md:text-lg font-semibold text-gray-900">Change Password</h3>
                                    <p class="text-xs md:text-sm text-gray-600">Update your account password</p>
                                </div>
                            </div>

                            <div class="max-w-md space-y-4">
                                <!-- Current Password -->
                                <div>
                                    <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Current Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" 
                                           name="current_password" 
                                           id="current_password"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('current_password') border-red-500 @enderror"
                                           required>
                                    @error('current_password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        New Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" 
                                           name="password" 
                                           id="password"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('password') border-red-500 @enderror"
                                           required>
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirm New Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           id="password_confirmation"
                                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200"
                                           required>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                        style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Preferences Tab -->
                <div x-show="activeTab === 'preferences'" x-transition>
                    <form method="POST" action="{{ route('profile.preferences') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="space-y-6">
                            <div class="flex items-center mb-4 md:mb-6">
                                <div class="p-2 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg mr-3">
                                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base md:text-lg font-semibold text-gray-900">Account Preferences</h3>
                                    <p class="text-xs md:text-sm text-gray-600">Customize your account settings</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                                        <!-- Notification Settings -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Notification Settings</h4>
                                            <div class="space-y-4">
                                                <div class="flex items-start">
                                                    <div class="flex items-center h-5 mt-1">
                                                        <input id="email_notifications" 
                                                               name="email_notifications" 
                                                               type="checkbox" 
                                                               value="1"
                                                               {{ ($user->preferences['email_notifications'] ?? true) ? 'checked' : '' }}
                                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                    </div>
                                                    <div class="ml-3">
                                                        <label for="email_notifications" class="text-sm font-semibold text-gray-700">
                                                            Email Notifications
                                                        </label>
                                                        <p class="text-sm text-gray-500">Receive general notifications via email</p>
                                                    </div>
                                                </div>

                                                <div class="flex items-start">
                                                    <div class="flex items-center h-5 mt-1">
                                                        <input id="order_notifications" 
                                                               name="order_notifications" 
                                                               type="checkbox" 
                                                               value="1"
                                                               {{ ($user->preferences['order_notifications'] ?? true) ? 'checked' : '' }}
                                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                    </div>
                                                    <div class="ml-3">
                                                        <label for="order_notifications" class="text-sm font-semibold text-gray-700">
                                                            Order Updates
                                                        </label>
                                                        <p class="text-sm text-gray-500">Get notified about order status changes</p>
                                                    </div>
                                                </div>

                                                <div class="flex items-start">
                                                    <div class="flex items-center h-5 mt-1">
                                                        <input id="marketing_emails" 
                                                               name="marketing_emails" 
                                                               type="checkbox" 
                                                               value="1"
                                                               {{ ($user->preferences['marketing_emails'] ?? false) ? 'checked' : '' }}
                                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                    </div>
                                                    <div class="ml-3">
                                                        <label for="marketing_emails" class="text-sm font-semibold text-gray-700">
                                                            Marketing Emails
                                                        </label>
                                                        <p class="text-sm text-gray-500">Receive promotional offers and deals</p>
                                                    </div>
                                                </div>

                                                <div class="flex items-start">
                                                    <div class="flex items-center h-5 mt-1">
                                                        <input id="newsletter_subscription" 
                                                               name="newsletter_subscription" 
                                                               type="checkbox" 
                                                               value="1"
                                                               {{ ($user->preferences['newsletter_subscription'] ?? false) ? 'checked' : '' }}
                                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                    </div>
                                                    <div class="ml-3">
                                                        <label for="newsletter_subscription" class="text-sm font-semibold text-gray-700">
                                                            Newsletter Subscription
                                                        </label>
                                                        <p class="text-sm text-gray-500">Subscribe to our weekly newsletter</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Regional Settings -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Regional Settings</h4>
                                            <div class="space-y-4">
                                                <!-- Timezone -->
                                                <div>
                                                    <label for="timezone" class="block text-sm font-semibold text-gray-700 mb-2">
                                                        Timezone
                                                    </label>
                                                    <select name="timezone" 
                                                            id="timezone"
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                                        <option value="Asia/Karachi" {{ ($user->preferences['timezone'] ?? 'Asia/Karachi') == 'Asia/Karachi' ? 'selected' : '' }}>Asia/Karachi (PKT)</option>
                                                        <option value="Asia/Dubai" {{ ($user->preferences['timezone'] ?? '') == 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai (GST)</option>
                                                        <option value="UTC" {{ ($user->preferences['timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                                    </select>
                                                </div>

                                                <!-- Language -->
                                                <div>
                                                    <label for="language" class="block text-sm font-semibold text-gray-700 mb-2">
                                                        Language
                                                    </label>
                                                    <select name="language" 
                                                            id="language"
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 force:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                                        <option value="en" {{ ($user->preferences['language'] ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                                                        <option value="ur" {{ ($user->preferences['language'] ?? '') == 'ur' ? 'selected' : '' }}>اردو (Urdu)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Update Preferences
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Orders Tab (for customers only) -->
                @if($orderStats)
                <div x-show="activeTab === 'orders'" x-transition>
                    <div class="space-y-6">
                        <div class="flex items-center mb-4 md:mb-6">
                            <div class="p-2 bg-gradient-to-br from-orange-100 to-amber-100 rounded-lg mr-3">
                                <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base md:text-lg font-semibold text-gray-900">Recent Orders</h3>
                                <p class="text-xs md:text-sm text-gray-600">Your order history and status</p>
                            </div>
                        </div>

                        @if($orderStats['recent_orders']->count() > 0)
                            <div class="space-y-4">
                                @foreach($orderStats['recent_orders'] as $order)
                                <a href="{{ route('orders.show', $order->id) }}" class="block border-2 border-amber-200 rounded-xl p-4 hover:shadow-lg hover:border-amber-400 transition-all bg-gradient-to-r from-white to-amber-50/30">
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                        <div class="flex items-center space-x-4 flex-1">
                                            <div class="h-10 w-10 bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg flex items-center justify-center shadow-md">
                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">Order #{{ $order->id }}</div>
                                                <div class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-left sm:text-right w-full sm:w-auto">
                                            <div class="font-bold text-lg bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">PKR {{ number_format($order->total_amount, 2) }}</div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $order->status_color ?? 'gray' }}-100 text-{{ $order->status_color ?? 'gray' }}-800 border border-{{ $order->status_color ?? 'gray' }}-300 mt-1">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            
                            <div class="text-center pt-4">
                                <a href="{{ route('orders.index') }}" 
                                   class="inline-flex items-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                   style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%) !important;">
                                    View All Orders
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="p-4 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                                <h4 class="text-base font-semibold text-gray-900 mb-2">No Orders Yet</h4>
                                <p class="text-sm text-gray-600 mb-6">You haven't placed any orders yet.</p>
                                <a href="{{ route('shop') }}" 
                                   class="inline-flex items-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                   style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%) !important;">
                                    Start Shopping
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border-2 border-red-200 mt-4 md:mt-6">
            <div class="p-4 md:p-6">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-gradient-to-br from-red-100 to-pink-100 rounded-lg mr-3">
                        <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base md:text-lg font-semibold text-gray-900">Delete Account</h3>
                        <p class="text-xs md:text-sm text-gray-600">Permanently delete your account and all associated data</p>
                    </div>
                </div>
                
                <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4 mb-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.665-.833-2.464 0L4.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-red-800">Warning</h4>
                            <div class="mt-1 text-sm text-red-700">
                                <p>This action cannot be undone. All your data including orders, preferences, and account information will be permanently deleted.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="button" 
                        onclick="showDeleteModal()"
                        class="inline-flex items-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm" x-data="{ show: false }" x-show="show" @click.away="show = false">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 border-2 border-red-200">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-gradient-to-br from-red-100 to-pink-100 rounded-lg mr-3">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Confirm Account Deletion</h3>
                    <p class="text-sm text-gray-600">This action cannot be undone</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                
                <div class="mb-4">
                    <label for="delete_password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Enter your password to confirm <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           id="delete_password"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200"
                           required>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <button type="button" 
                            onclick="document.getElementById('deleteModal').style.display='none'"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors font-semibold">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-white rounded-lg transition-all font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                            style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showDeleteModal() {
        document.getElementById('deleteModal').style.display = 'flex';
    }
</script>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-green-100 border-2 border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-xl" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 z-50 bg-red-100 border-2 border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-xl" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            {{ session('error') }}
        </div>
    </div>
@endif
@endsection
