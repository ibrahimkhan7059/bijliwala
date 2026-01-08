<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AJ Electric - Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-orange-50 via-pink-50 to-blue-50 relative">
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 -z-10">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-gradient-to-r from-orange-400/20 to-red-400/20 rounded-full animate-pulse"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-gradient-to-r from-blue-400/20 to-purple-400/20 rounded-full animate-bounce"></div>
        <div class="absolute top-1/3 right-1/4 w-48 h-48 bg-gradient-to-r from-pink-300/10 to-orange-300/10 rounded-full animate-ping"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-md w-full space-y-6 page-transition my-4">
            <!-- Header Section -->
            <div class="text-center animate-slide-up">
                <div class="mx-auto h-20 w-20 mb-6 animate-bounce shadow-2xl">
                    <img src="{{ asset('images/logo.avif') }}" alt="AJ Electric Logo" class="h-20 w-20 object-contain rounded-3xl">
                </div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-500 to-blue-600 bg-clip-text text-transparent mb-2">Welcome!</h1>
                <p class="text-gray-600 text-lg">AJ Electric</p>
            </div>

            <!-- Toggle Buttons -->
            <div class="flex bg-gray-100 rounded-xl p-1 animate-fade-slide" style="animation-delay: 0.2s;">
                <button type="button" 
                        class="flex-1 py-2 px-4 text-sm font-medium rounded-lg transition-all duration-300 text-gray-500 hover:text-gray-700"
                        id="signin-tab"
                        onclick="switchToSignin()">
                    Sign In
                </button>
                <button type="button" 
                        class="flex-1 py-2 px-4 text-sm font-medium rounded-lg transition-all duration-300 bg-white text-orange-600 shadow-sm"
                        id="signup-tab">
                    Sign Up
                </button>
            </div>

            <!-- Registration Form -->
            <div class="card p-8 animate-fade-slide backdrop-blur-sm bg-white/90 shadow-2xl border border-white/20">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div class="animate-slide-in-right">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                class="form-input pl-10 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror"
                                placeholder="Enter your full name"
                                minlength="2"
                                maxlength="255"
                                pattern="[A-Za-z\s]+"
                                oninput="validateName(this)">
                        </div>
                        <p id="name-error" class="mt-1 text-sm text-red-600 hidden"></p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="animate-slide-in-right" style="animation-delay: 0.1s;">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                class="form-input pl-10 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('email') border-red-500 @enderror"
                                placeholder="Enter your email address"
                                oninput="validateEmail(this)">
                        </div>
                        <p id="email-error" class="mt-1 text-sm text-red-600 hidden"></p>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="animate-slide-in-right" style="animation-delay: 0.2s;">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="form-input pl-10 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('password') border-red-500 @enderror"
                                placeholder="Create a password"
                                minlength="8"
                                oninput="validatePassword(this); checkPasswordMatch();">
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
                        <p id="password-error" class="mt-1 text-sm text-red-600 hidden"></p>
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
                        <button type="submit" id="register-submit" class="w-full btn-primary hover-lift disabled:opacity-50 disabled:cursor-not-allowed">
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

            <!-- Back to Home -->
            <div class="text-center animate-fade-in" style="animation-delay: 0.5s;">
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
        function validateName(input) {
            const name = input.value.trim();
            const nameError = document.getElementById('name-error');
            
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
            const password = document.getElementById('password').value;
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

        // Form validation on submit
        document.querySelector('form[action="{{ route('register') }}"]').addEventListener('submit', function(e) {
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            
            const nameValid = validateName(name);
            const emailValid = validateEmail(email);
            const passwordValid = validatePassword(password);
            const confirmValid = checkPasswordMatch();
            
            if (!nameValid || !emailValid || !passwordValid || !confirmValid) {
                e.preventDefault();
                return false;
            }
        });

        // Switch to Signin with smooth transition
        function switchToSignin() {
            // Add exit animation
            document.querySelector('.page-transition').style.animation = 'fadeOut 0.3s ease-in-out';
            
            // Navigate after animation
            setTimeout(() => {
                window.location.href = '{{ route("login") }}';
            }, 300);
        }

        // Add fadeOut animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeOut {
                from { opacity: 1; transform: scale(1); }
                to { opacity: 0; transform: scale(0.95); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
