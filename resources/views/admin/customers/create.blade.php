@extends('admin.layout')

@section('title', 'Add New Customer')
@section('page-title', 'Add New Customer')

@section('content')
<div class="animate-fade-in max-w-full overflow-hidden">
    <!-- Professional Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6 animate-slide-in-down">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Add New Customer</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Create a new customer account</p>
                </div>
            </div>
            <div class="flex gap-2 sm:gap-3">
                <!-- Back Button -->
                <a href="{{ route('admin.customers.index') }}" 
                   class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 text-gray-700 text-xs sm:text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-gray-300 hover:border-gray-400 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Back to Customers</span>
                    <span class="sm:hidden">Back</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 animate-slide-in-up">
        <form method="POST" action="{{ route('admin.customers.store') }}">
            @csrf
            
            <div class="p-4 sm:p-6">
                <!-- Personal Information Section -->
                <div class="mb-6 sm:mb-8">
                    <div class="flex items-center mb-4 sm:mb-6">
                        <div class="p-2 bg-purple-100 rounded-lg mr-3">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900">Personal Information</h3>
                            <p class="text-sm text-gray-600">Basic customer details</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 @error('name') border-red-500 @enderror"
                                   placeholder="Enter customer's full name"
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
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 @error('email') border-red-500 @enderror"
                                   placeholder="Enter email address"
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
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 @error('phone') border-red-500 @enderror"
                                   placeholder="Enter phone number (optional)">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 @error('password') border-red-500 @enderror"
                                   placeholder="Enter password"
                                   required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Settings Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Account Settings</h3>
                            <p class="text-sm text-gray-600">Configure account options</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email Verification -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5 mt-1">
                                <input id="email_verified" 
                                       name="email_verified" 
                                       type="checkbox" 
                                       value="1"
                                       {{ old('email_verified') ? 'checked' : '' }}
                                       class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            </div>
                            <div class="ml-3">
                                <label for="email_verified" class="text-sm font-semibold text-gray-700">
                                    Mark Email as Verified
                                </label>
                                <p class="text-sm text-gray-500">If checked, the customer won't need to verify their email</p>
                            </div>
                        </div>

                        <!-- Send Welcome Email -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5 mt-1">
                                <input id="send_welcome_email" 
                                       name="send_welcome_email" 
                                       type="checkbox" 
                                       value="1"
                                       {{ old('send_welcome_email', true) ? 'checked' : '' }}
                                       class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                            </div>
                            <div class="ml-3">
                                <label for="send_welcome_email" class="text-sm font-semibold text-gray-700">
                                    Send Welcome Email
                                </label>
                                <p class="text-sm text-gray-500">Send an email to the customer with login credentials</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-green-100 rounded-lg mr-3">
                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Additional Information</h3>
                            <p class="text-sm text-gray-600">Optional customer notes</p>
                        </div>
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                            Customer Notes
                        </label>
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 @error('notes') border-red-500 @enderror"
                                  placeholder="Add any notes about this customer (optional)">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">Internal notes visible only to administrators</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex flex-col sm:flex-row gap-4 justify-end">
                        <!-- Cancel Button -->
                        <a href="{{ route('admin.customers.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 text-gray-700 text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-gray-300 hover:border-gray-400 bg-white hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        
                        <!-- Save Button -->
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 text-white text-sm font-bold rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl border-2 border-transparent"
                                style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Customer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Form Enhancement Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format phone number
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.startsWith('92')) {
                    value = '+' + value;
                } else if (value.startsWith('0')) {
                    value = '+92' + value.substring(1);
                } else if (!value.startsWith('+')) {
                    value = '+92' + value;
                }
            }
            e.target.value = value;
        });
    }

    // Form validation enhancements
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Creating Customer...
        `;
        
        // Re-enable after 10 seconds as fallback
        setTimeout(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create Customer
            `;
        }, 10000);
    });

    // Input focus effects
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-purple-500');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-purple-500');
        });
    });
});
</script>
@endsection
