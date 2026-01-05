<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.avif') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.avif') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.avif') }}">
    
    <title>{{ config('app.name', 'AJelectric') }} - Authentication</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 relative">
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 -z-10">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-amber-400/20 to-orange-400/20 rounded-full animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-r from-orange-400/20 to-red-400/20 rounded-full animate-bounce"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-yellow-300/10 to-amber-300/10 rounded-full animate-ping"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center py-4 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-md w-full space-y-4 md:space-y-6 page-transition my-2 md:my-4">
            <!-- Header Section -->
            <div class="text-center animate-slide-up">
                <div class="mx-auto h-16 w-16 md:h-20 md:w-20 mb-4 md:mb-6 animate-bounce shadow-2xl">
                    <img src="{{ asset('images/logo.avif') }}" alt="AJelectric Logo" class="h-16 w-16 md:h-20 md:w-20 object-contain rounded-3xl">
                </div>
                <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-amber-600 via-orange-500 to-red-600 bg-clip-text text-transparent mb-2">Welcome Back!</h1>
                <p class="text-gray-600 text-base md:text-lg font-medium">AJelectric</p>
            </div>

            <!-- Toggle Buttons -->
            <div class="flex bg-gradient-to-r from-orange-100 to-amber-100 rounded-xl p-1 animate-fade-slide shadow-inner" style="animation-delay: 0.2s;">
                <button type="button" 
                        class="flex-1 py-2.5 px-4 text-sm md:text-base font-bold rounded-lg transition-all duration-300 bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg"
                        id="signin-tab"
                        onclick="showSignin()">
                    Sign In
                </button>
                <button type="button" 
                        class="flex-1 py-2.5 px-4 text-sm md:text-base font-semibold rounded-lg transition-all duration-300 text-gray-600 hover:text-gray-800"
                        id="signup-tab"
                        onclick="showSignup()">
                    Sign Up
                </button>
            </div>

            <!-- Auth Forms Container -->
            <div class="card p-6 md:p-8 animate-fade-slide backdrop-blur-sm bg-gradient-to-br from-white to-orange-50/30 shadow-2xl border-2 border-orange-200">
                
                <!-- Login Form -->
                <div id="signin-form" class="auth-form">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="animate-slide-in-left" style="animation-delay: 0.1s;">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                class="form-input pl-10 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('email') border-red-500 @enderror"
                                placeholder="Enter your email"
                                oninput="validateEmail(this)">
                        </div>
                        <p id="email-error" class="mt-1 text-sm text-red-600 hidden"></p>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="animate-slide-in-left" style="animation-delay: 0.2s;">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="form-input pl-10 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('password') border-red-500 @enderror"
                                placeholder="Enter your password"
                                minlength="6"
                                oninput="validatePassword(this)">
                        </div>
                        <p id="password-error" class="mt-1 text-sm text-red-600 hidden"></p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between animate-slide-in-left" style="animation-delay: 0.3s;">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" 
                                class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                                class="text-sm text-orange-600 hover:text-orange-800 font-medium transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <div class="animate-slide-in-left" style="animation-delay: 0.4s;">
                        <button type="submit" id="login-submit"
                            class="w-full py-3 md:py-4 text-base md:text-lg font-bold text-white bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 hover:from-amber-600 hover:via-orange-600 hover:to-red-600 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Sign In
                            </span>
                        </button>
                    </div>

                </form>
                </div>

                <!-- Signup Form -->
                <div id="signup-form" class="auth-form hidden">
                    <form method="POST" action="{{ route('register') }}" class="space-y-4 md:space-y-6">
                        @csrf

                        <!-- Name -->
                        <div class="animate-slide-in-right">
                            <label for="register-name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input id="register-name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                    class="form-input pl-10 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror"
                                    placeholder="Enter your full name"
                                    minlength="2"
                                    maxlength="255"
                                    pattern="[A-Za-z\s]+"
                                    oninput="validateName(this)">
                            </div>
                            <p id="register-name-error" class="mt-1 text-sm text-red-600 hidden"></p>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="animate-slide-in-right" style="animation-delay: 0.1s;">
                            <label for="register-email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input id="register-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                    class="form-input pl-10 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('email') border-red-500 @enderror"
                                    placeholder="Enter your email address"
                                    oninput="validateRegisterEmail(this)">
                            </div>
                            <p id="register-email-error" class="mt-1 text-sm text-red-600 hidden"></p>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="animate-slide-in-right" style="animation-delay: 0.2s;">
                            <label for="register-password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="register-password" type="password" name="password" required autocomplete="new-password"
                                    class="form-input pl-10 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('password') border-red-500 @enderror"
                                    placeholder="Create a password"
                                    minlength="8"
                                    oninput="validateRegisterPassword(this); checkPasswordMatch();">
                            </div>
                            <div id="password-strength" class="mt-2 hidden">
                                <div class="text-xs text-gray-600 mb-1">Password strength:</div>
                                <div class="flex gap-1">
                                    <div id="strength-weak" class="h-1 flex-1 bg-gray-200 rounded"></div>
                                    <div id="strength-medium" class="h-1 flex-1 bg-gray-200 rounded"></div>
                                    <div id="strength-strong" class="h-1 flex-1 bg-gray-200 rounded"></div>
                                </div>
                                <p id="password-requirements" class="text-xs text-gray-600 mt-1"></p>
                            </div>
                            <p id="register-password-error" class="mt-1 text-sm text-red-600 hidden"></p>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="animate-slide-in-right" style="animation-delay: 0.3s;">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                    class="form-input pl-10 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                    placeholder="Confirm your password"
                                    oninput="checkPasswordMatch()">
                            </div>
                            <p id="password-confirmation-error" class="mt-1 text-sm text-red-600 hidden"></p>
                        </div>

                        <!-- Submit Button -->
                        <div class="animate-scale-in" style="animation-delay: 0.4s;">
                            <button type="submit" id="register-submit" class="w-full py-3 md:py-4 text-base md:text-lg font-bold text-white bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 hover:from-amber-600 hover:via-orange-600 hover:to-red-600 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    Create Account
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center animate-fade-in" style="animation-delay: 0.7s;">
                <a href="{{ route('home') }}" 
                    class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Website
                </a>
            </div>
        </div>
    </div>

    <script>
        // Validation functions
        function validateEmail(input) {
            const email = input.value.trim();
            const emailError = document.getElementById('email-error');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email === '') {
                emailError.textContent = 'Email is required';
                emailError.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            } else if (!emailRegex.test(email)) {
                emailError.textContent = 'Please enter a valid email address';
                emailError.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            } else {
                emailError.classList.add('hidden');
                input.classList.remove('border-red-500');
                return true;
            }
        }

        function validatePassword(input) {
            const password = input.value;
            const passwordError = document.getElementById('password-error');
            
            if (password === '') {
                passwordError.textContent = 'Password is required';
                passwordError.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            } else if (password.length < 6) {
                passwordError.textContent = 'Password must be at least 6 characters';
                passwordError.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            } else {
                passwordError.classList.add('hidden');
                input.classList.remove('border-red-500');
                return true;
            }
        }

        // Form validation on submit
        document.querySelector('form[action="{{ route('login') }}"]').addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const emailValid = validateEmail(email);
            const passwordValid = validatePassword(password);
            
            if (!emailValid || !passwordValid) {
                e.preventDefault();
                return false;
            }
        });

        // Form switching functions
        function showSignin() {
            const signinForm = document.getElementById('signin-form');
            const signupForm = document.getElementById('signup-form');
            const signinTab = document.getElementById('signin-tab');
            const signupTab = document.getElementById('signup-tab');
            
            // Hide signup form with animation
            signupForm.style.animation = 'slideOut 0.3s ease-in-out';
            
            setTimeout(() => {
                signupForm.classList.add('hidden');
                signinForm.classList.remove('hidden');
                
                // Show signin form with animation
                signinForm.style.animation = 'slideIn 0.4s ease-in-out';
                
                // Update tab styles
                signinTab.className = 'flex-1 py-2.5 px-4 text-sm md:text-base font-bold rounded-lg transition-all duration-300 bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg';
                signupTab.className = 'flex-1 py-2.5 px-4 text-sm md:text-base font-semibold rounded-lg transition-all duration-300 text-gray-600 hover:text-gray-800';
            }, 300);
        }
        
        function showSignup() {
            const signinForm = document.getElementById('signin-form');
            const signupForm = document.getElementById('signup-form');
            const signinTab = document.getElementById('signin-tab');
            const signupTab = document.getElementById('signup-tab');
            
            // Hide signin form with animation
            signinForm.style.animation = 'slideOut 0.3s ease-in-out';
            
            setTimeout(() => {
                signinForm.classList.add('hidden');
                signupForm.classList.remove('hidden');
                
                // Show signup form with animation
                signupForm.style.animation = 'slideIn 0.4s ease-in-out';
                
                // Update tab styles
                signupTab.className = 'flex-1 py-2.5 px-4 text-sm md:text-base font-bold rounded-lg transition-all duration-300 bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg';
                signinTab.className = 'flex-1 py-2.5 px-4 text-sm md:text-base font-semibold rounded-lg transition-all duration-300 text-gray-600 hover:text-gray-800';
            }, 300);
        }

        // Register form validation functions
        function validateName(input) {
            const name = input.value.trim();
            const nameError = document.getElementById('register-name-error');
            
            if (name === '') {
                nameError.textContent = 'Name is required';
                nameError.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            } else if (name.length < 2) {
                nameError.textContent = 'Name must be at least 2 characters';
                nameError.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            } else if (!/^[A-Za-z\s]+$/.test(name)) {
                nameError.textContent = 'Name can only contain letters and spaces';
                nameError.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            } else {
                nameError.classList.add('hidden');
                input.classList.remove('border-red-500');
                return true;
            }
        }

        function validateRegisterEmail(input) {
            const email = input.value.trim();
            const emailError = document.getElementById('register-email-error');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email === '') {
                emailError.textContent = 'Email is required';
                emailError.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            } else if (!emailRegex.test(email)) {
                emailError.textContent = 'Please enter a valid email address';
                emailError.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            } else {
                emailError.classList.add('hidden');
                input.classList.remove('border-red-500');
                return true;
            }
        }

        function validateRegisterPassword(input) {
            const password = input.value;
            const passwordError = document.getElementById('register-password-error');
            const strengthDiv = document.getElementById('password-strength');
            const requirements = document.getElementById('password-requirements');
            
            if (password === '') {
                passwordError.textContent = 'Password is required';
                passwordError.classList.remove('hidden');
                input.classList.add('border-red-500');
                strengthDiv.classList.add('hidden');
                return false;
            } else if (password.length < 8) {
                passwordError.textContent = 'Password must be at least 8 characters';
                passwordError.classList.remove('hidden');
                input.classList.add('border-red-500');
                strengthDiv.classList.remove('hidden');
                requirements.textContent = 'At least 8 characters required';
                updatePasswordStrength(password, 'weak');
                return false;
            } else {
                passwordError.classList.add('hidden');
                input.classList.remove('border-red-500');
                strengthDiv.classList.remove('hidden');
                
                // Check password strength
                let strength = 'weak';
                let requirementsText = [];
                
                if (password.length >= 8) {
                    requirementsText.push('✓ 8+ characters');
                }
                if (/[a-z]/.test(password)) {
                    requirementsText.push('✓ Lowercase');
                }
                if (/[A-Z]/.test(password)) {
                    requirementsText.push('✓ Uppercase');
                }
                if (/[0-9]/.test(password)) {
                    requirementsText.push('✓ Number');
                }
                if (/[^A-Za-z0-9]/.test(password)) {
                    requirementsText.push('✓ Special character');
                }
                
                if (requirementsText.length >= 4) {
                    strength = 'strong';
                } else if (requirementsText.length >= 3) {
                    strength = 'medium';
                }
                
                requirements.textContent = requirementsText.join(' • ');
                updatePasswordStrength(password, strength);
                return true;
            }
        }

        function updatePasswordStrength(password, strength) {
            const weak = document.getElementById('strength-weak');
            const medium = document.getElementById('strength-medium');
            const strong = document.getElementById('strength-strong');
            
            // Reset
            weak.className = 'h-1 flex-1 bg-gray-200 rounded';
            medium.className = 'h-1 flex-1 bg-gray-200 rounded';
            strong.className = 'h-1 flex-1 bg-gray-200 rounded';
            
            if (strength === 'weak') {
                weak.className = 'h-1 flex-1 bg-red-500 rounded';
            } else if (strength === 'medium') {
                weak.className = 'h-1 flex-1 bg-yellow-500 rounded';
                medium.className = 'h-1 flex-1 bg-yellow-500 rounded';
            } else if (strength === 'strong') {
                weak.className = 'h-1 flex-1 bg-green-500 rounded';
                medium.className = 'h-1 flex-1 bg-green-500 rounded';
                strong.className = 'h-1 flex-1 bg-green-500 rounded';
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('register-password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const error = document.getElementById('password-confirmation-error');
            
            if (confirmPassword === '') {
                error.classList.add('hidden');
                return true;
            } else if (password !== confirmPassword) {
                error.textContent = 'Passwords do not match';
                error.classList.remove('hidden');
                document.getElementById('password_confirmation').classList.add('border-red-500');
                return false;
            } else {
                error.classList.add('hidden');
                document.getElementById('password_confirmation').classList.remove('border-red-500');
                return true;
            }
        }

        // Register form validation on submit
        document.querySelector('form[action="{{ route('register') }}"]')?.addEventListener('submit', function(e) {
            const name = document.getElementById('register-name');
            const email = document.getElementById('register-email');
            const password = document.getElementById('register-password');
            const confirmPassword = document.getElementById('password_confirmation');
            
            const nameValid = validateName(name);
            const emailValid = validateRegisterEmail(email);
            const passwordValid = validateRegisterPassword(password);
            const confirmValid = checkPasswordMatch();
            
            if (!nameValid || !emailValid || !passwordValid || !confirmValid) {
                e.preventDefault();
                return false;
            }
        });

        // Check URL and show appropriate form
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.pathname.includes('register')) {
                showSignup();
            }
        });

        // Add custom animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideOut {
                from { opacity: 1; transform: translateX(0); }
                to { opacity: 0; transform: translateX(-20px); }
            }
            
            @keyframes slideIn {
                from { opacity: 0; transform: translateX(20px); }
                to { opacity: 1; transform: translateX(0); }
            }
            
            .auth-form {
                transition: all 0.3s ease-in-out;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
