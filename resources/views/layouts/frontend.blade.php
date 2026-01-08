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

    <title>@yield('title', 'AJ Electric')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Alpine.js x-cloak */
        [x-cloak] { display: none !important; }
        
        /* Body scroll lock when sidebar open - only on mobile */
        @media (max-width: 768px) {
            body.menu-open {
                overflow: hidden;
                position: fixed;
                width: 100%;
            }
        }
        
        /* Electrical & Solar Theme Colors */
        :root {
            --primary-yellow: #f59e0b;
            --primary-orange: #ea580c;
            --electric-blue: #0ea5e9;
            --solar-yellow: #fbbf24;
            --energy-green: #22c55e;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%) !important;
            color: white !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem !important;
            font-weight: 600 !important;
            border: none !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.4) !important;
        }
        .btn-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.5) !important;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%) !important;
        }
        .btn-success {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%) !important;
            color: white !important;
            box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.3) !important;
        }
        .btn-success:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 15px -3px rgba(34, 197, 94, 0.4) !important;
        }
        .btn-warning {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
            color: white !important;
            box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.3) !important;
        }
        .btn-warning:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 15px -3px rgba(249, 115, 22, 0.4) !important;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .electric-gradient {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        }
        
        .solar-gradient {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }
        
        @media (max-width: 640px) {
            .mobile-padding {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(245, 158, 11, 0.2), 0 10px 10px -5px rgba(245, 158, 11, 0.1);
        }
        
        .smooth-scroll {
            scroll-behavior: smooth;
        }
        
        /* Lightning animation for electrical theme */
        @keyframes lightning {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .lightning-pulse {
            animation: lightning 2s ease-in-out infinite;
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased smooth-scroll" style="background: linear-gradient(135deg, #fff5e6 0%, #ffe4c4 25%, #ffd7a8 50%, #ffedd5 75%, #fff5e6 100%); background-attachment: fixed;" x-data="{ mobileMenuOpen: false }">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-white/98 via-orange-50/30 to-white/98 backdrop-blur-md border-b-2 border-orange-200 sticky top-0 z-50 shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16 md:h-20">
                <!-- Logo Section -->
                <div class="flex items-center flex-shrink-0">
                    <!-- Mobile Menu Button (Open) -->
                    <button @click="mobileMenuOpen = true" 
                            type="button"
                            class="md:hidden mr-3 p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-500"
                            aria-label="Open menu">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.avif') }}" alt="AJelectric Logo" class="h-10 w-10 md:h-12 md:w-12 object-contain">
                        <div class="flex flex-col">
                            <span class="text-lg md:text-xl font-bold gradient-text leading-tight whitespace-nowrap">AJelectric</span>
                            <span class="text-[10px] text-amber-600 hidden lg:block font-semibold whitespace-nowrap">Electrical & Solar Products</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links (Center) -->
                <div class="hidden lg:flex items-center justify-center flex-1 space-x-1 mx-4">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all whitespace-nowrap {{ request()->routeIs('home') ? 'bg-gradient-to-r from-amber-50 to-orange-50 text-orange-700' : 'text-gray-700 hover:bg-amber-50' }}">
                        Home
                    </a>
                    <a href="{{ route('home') }}#shop" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all whitespace-nowrap {{ request()->routeIs('home') && request()->get('_fragment') == 'shop' ? 'bg-gradient-to-r from-amber-50 to-orange-50 text-orange-700' : 'text-gray-700 hover:bg-amber-50' }}">
                        Shop
                    </a>
                    <a href="{{ route('home') }}#products" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all whitespace-nowrap {{ request()->routeIs('home') && request()->get('_fragment') == 'products' ? 'bg-gradient-to-r from-amber-50 to-orange-50 text-orange-700' : 'text-gray-700 hover:bg-amber-50' }}">
                        Products
                    </a>
                    <a href="{{ route('home') }}#about" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all whitespace-nowrap {{ request()->routeIs('home') && request()->get('_fragment') == 'about' ? 'bg-gradient-to-r from-amber-50 to-orange-50 text-orange-700' : 'text-gray-700 hover:bg-amber-50' }}">
                        About
                    </a>
                    <a href="{{ route('blog.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all whitespace-nowrap {{ request()->routeIs('blog.*') ? 'bg-gradient-to-r from-amber-50 to-orange-50 text-orange-700' : 'text-gray-700 hover:bg-amber-50' }}">
                        Blog
                    </a>
                    @auth
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all whitespace-nowrap {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-amber-50 to-orange-50 text-orange-700' : 'text-gray-700 hover:bg-amber-50' }}">
                            Admin Panel
                        </a>
                        @else
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-all whitespace-nowrap {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-amber-50 to-orange-50 text-orange-700' : 'text-gray-700 hover:bg-amber-50' }}">
                            Dashboard
                        </a>
                        @endif
                    @endauth
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-1 md:space-x-2 flex-shrink-0">
                    <!-- Search Icon (Mobile) -->
                    <button onclick="document.getElementById('mobile-search').classList.toggle('hidden')" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <!-- Desktop Search -->
                    <form action="{{ route('shop') }}" method="GET" class="hidden lg:block">
                        <div class="relative">
                            <input type="search" name="search" placeholder="Search..." 
                                   value="{{ request('search') }}"
                                   class="pl-10 pr-4 py-2 w-48 xl:w-56 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </form>

                    <!-- Wishlist (Authenticated Users Only) -->
                    @auth
                    <a href="{{ route('wishlist.index') }}" class="hidden md:block relative p-2 rounded-lg hover:bg-amber-50 transition-all" title="Wishlist">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </a>
                    @endauth

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg hover:bg-amber-50 transition-all" title="Shopping Cart">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-gradient-to-r from-amber-500 to-orange-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-lg">0</span>
                    </a>

                    <!-- User Menu -->
                    @auth
                        <div x-data="{ open: false }" @click.away="open = false" class="relative hidden md:block">
                            <button @click="open = !open" type="button" class="flex items-center space-x-1 xl:space-x-2 px-2 xl:px-3 py-2 rounded-lg hover:bg-amber-50 transition-all focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-full flex items-center justify-center text-white font-semibold text-sm shadow-lg flex-shrink-0">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-semibold text-gray-700 hidden xl:block max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" 
                                 x-cloak
                                 style="display: none;"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 ring-1 ring-black ring-opacity-5 z-50">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 hover:text-orange-700 transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 hover:text-orange-700 transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile
                                </a>
                                @if(!Auth::user()->isAdmin())
                                    <a href="{{ route('cart.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 hover:text-orange-700 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        My Cart
                                    </a>
                                @endif
                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden lg:block text-sm font-semibold text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-lg hover:bg-gray-100 transition-all whitespace-nowrap">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="hidden lg:block btn-primary text-sm px-3 py-2 rounded-lg whitespace-nowrap">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>

            <!-- Mobile Search Bar (Hidden by default) -->
            <div id="mobile-search" class="hidden md:hidden pb-3">
                <form action="{{ route('shop') }}" method="GET">
                    <div class="relative">
                <input type="search" name="search" placeholder="Search products..." 
                       value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
            </form>
            </div>
        </div>

        <!-- Mobile Menu Sidebar -->
        <div x-show="mobileMenuOpen" 
             x-cloak
             @click.away="if(window.innerWidth < 768) mobileMenuOpen = false"
             @keydown.escape.window="mobileMenuOpen = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed top-0 left-0 w-64 bg-white shadow-2xl md:hidden z-[100] overflow-y-auto"
             style="height: 100vh; height: 100dvh; bottom: 0;"
             role="dialog"
             aria-modal="true"
             aria-label="Mobile menu">
            <div class="p-6">
                <!-- Close Button Inside Sidebar -->
                <div class="flex items-center justify-between mb-6">
                    <button @click="mobileMenuOpen = false" 
                            type="button"
                            class="p-2 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-500"
                            aria-label="Close menu">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="text-xl font-bold gradient-text">Menu</span>
                </div>

                <div class="space-y-2">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-semibold {{ request()->routeIs('home') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-amber-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                Home
            </a>
                    <a href="{{ route('home') }}#shop" class="flex items-center px-4 py-3 rounded-lg text-base font-semibold {{ request()->routeIs('home') && request()->get('_fragment') == 'shop' ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-amber-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                Shop
            </a>
                    <a href="{{ route('home') }}#products" class="flex items-center px-4 py-3 rounded-lg text-base font-semibold {{ request()->routeIs('home') && request()->get('_fragment') == 'products' ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-amber-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                Products
            </a>
                    <a href="{{ route('home') }}#about" class="flex items-center px-4 py-3 rounded-lg text-base font-semibold {{ request()->routeIs('home') && request()->get('_fragment') == 'about' ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-amber-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                About
            </a>
                    <a href="{{ route('blog.index') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-semibold {{ request()->routeIs('blog.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-amber-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                Blog
            </a>
                    <a href="{{ route('cart.index') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-semibold {{ request()->routeIs('cart.index') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-amber-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        My Cart
                    </a>
                    @auth
                    <a href="{{ route('wishlist.index') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-semibold {{ request()->routeIs('wishlist.index') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-amber-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        My Wishlist
                    </a>
                    @endauth
                    
            @auth
                        <div class="border-t border-gray-200 my-4 pt-4">
                            <div class="px-4 py-2 mb-2">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                        Admin Panel
                    </a>
                @else
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-semibold {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Dashboard
                    </a>
                @endif
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-semibold text-gray-700 hover:bg-gray-100">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-3 rounded-lg text-base font-semibold text-red-600 hover:bg-red-50">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-gray-200 my-4 pt-4 space-y-2">
                            <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 rounded-lg text-base font-semibold text-gray-700 border-2 border-gray-300 hover:bg-gray-50">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="block w-full text-center btn-primary px-4 py-3 rounded-lg text-base font-semibold">
                                Register
                            </a>
                        </div>
            @endauth
        </div>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen" 
             x-cloak
             @click="mobileMenuOpen = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 md:hidden z-[90]"></div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 px-4 py-4 rounded-lg shadow-md flex items-center justify-between" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 px-4 py-4 rounded-lg shadow-md flex items-center justify-between" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-orange-900 to-amber-900 text-white mt-16 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- About Section -->
                <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="text-3xl">⚡</span>
                        <div>
                            <h3 class="text-xl font-bold text-white">AJelectric</h3>
                            <p class="text-xs text-gray-400">Electrical & Solar</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Your trusted source for quality electrical and solar products across Pakistan. We deliver excellence with every order.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4 text-white">Quick Links</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}#shop" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Shop
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}#products" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Products
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}#about" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                About
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('blog.index') }}" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Blog
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Cart
                            </a>
                        </li>
                        @auth
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-bold mb-4 text-white">Contact Us</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start text-sm">
                            <svg class="w-5 h-5 mr-3 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <div>
                                <p class="text-gray-400">WhatsApp Only</p>
                                <p class="text-white font-semibold">0333-7449456</p>
                            </div>
                        </li>
                        <li class="flex items-start text-sm">
                            <svg class="w-5 h-5 mr-3 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                <div>
                                <p class="text-gray-400">Email</p>
                                <p class="text-white">info@ajelectric.com</p>
                </div>
                        </li>
                        <li class="flex items-start text-sm">
                            <svg class="w-5 h-5 mr-3 text-yellow-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                <div>
                                <p class="text-gray-400">Location</p>
                                <p class="text-white">Rahim Yar Khan, Pakistan</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Features -->
                <div>
                    <h3 class="text-lg font-bold mb-4 text-white">Why Choose Us</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center text-sm text-gray-400">
                            <svg class="w-5 h-5 mr-3 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Fast Delivery (3-5 Days)
                        </li>
                        <li class="flex items-center text-sm text-gray-400">
                            <svg class="w-5 h-5 mr-3 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Genuine Products
                        </li>
                        <li class="flex items-center text-sm text-gray-400">
                            <svg class="w-5 h-5 mr-3 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            24/7 WhatsApp Support
                        </li>
                        <li class="flex items-center text-sm text-gray-400">
                            <svg class="w-5 h-5 mr-3 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Best Prices in Pakistan
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <p class="text-gray-400 text-sm text-center sm:text-left">
                        &copy; {{ date('Y') }} <span class="font-semibold text-white">Bijli Wala Bhai</span>. All rights reserved.
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">Privacy Policy</span>
                            <span class="text-sm">Privacy</span>
                        </a>
                        <span class="text-gray-600">|</span>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">Terms</span>
                            <span class="text-sm">Terms</span>
                        </a>
                </div>
            </div>
            </div>
        </div>
    </footer>

    <script>
        // Update cart count on page load
        async function updateCartCount() {
            try {
                const response = await fetch('{{ route("cart.count") }}');
                const data = await response.json();
                document.getElementById('cart-count').textContent = data.count;
            } catch (error) {
                console.error('Error fetching cart count:', error);
            }
        }

        // Update cart count on page load
        updateCartCount();
        
        // Handle anchor links for smooth scrolling
        document.addEventListener('DOMContentLoaded', function() {
            // Handle anchor links in navigation
            const anchorLinks = document.querySelectorAll('a[href*="#shop"], a[href*="#products"], a[href*="#about"]');
            anchorLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href && href.includes('#')) {
                        const hash = href.split('#')[1];
                        const currentPath = window.location.pathname;
                        const isHomePage = currentPath === '/' || currentPath === '{{ route("home") }}';
                        
                        // If we're on home page, scroll directly
                        if (isHomePage) {
                            e.preventDefault();
                            const targetElement = document.getElementById(hash);
                            if (targetElement) {
                                targetElement.scrollIntoView({ 
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                                // Update URL without reload
                                history.pushState(null, null, '#' + hash);
                            }
                        } else {
                            // If we're on a different page, store hash and navigate
                            sessionStorage.setItem('scrollTo', hash);
                            // Let the link navigate normally to home page
                        }
                    }
                });
            });
            
            // Check if we need to scroll after page load (from sessionStorage or URL hash)
            const scrollTo = sessionStorage.getItem('scrollTo') || window.location.hash.substring(1);
            if (scrollTo) {
                sessionStorage.removeItem('scrollTo');
                setTimeout(() => {
                    const targetElement = document.getElementById(scrollTo);
                    if (targetElement) {
                        targetElement.scrollIntoView({ 
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }, 300);
            }
        });
    </script>

    <!-- Alpine.js - Load from CDN (works even if Vite assets not built) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <style>
        /* Hide elements with x-cloak until Alpine.js is ready */
        [x-cloak] { 
            display: none !important; 
        }
        
        /* Prevent body scroll when mobile menu is open - only on mobile */
        @media (max-width: 768px) {
            body.menu-open {
                overflow: hidden;
                position: fixed;
                width: 100%;
            }
            
            /* Ensure sidebar is properly positioned and visible when open */
            nav[x-data] [x-show="mobileMenuOpen"] {
                display: block !important;
            }
        }
        
        /* Ensure body can scroll normally on desktop and when menu is closed */
        body {
            overflow-x: hidden;
            overflow-y: auto;
        }
        
        /* Smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
        }
        
        /* Offset for fixed header when scrolling to sections */
        section[id], div[id] {
            scroll-margin-top: 100px;
        }
    </style>
    
    <script>
        // Ensure Alpine.js is loaded and initialized
        function initAlpineMenu() {
            if (window.Alpine && window.Alpine.$data) {
                // Handle body scroll lock when menu opens/closes - only on mobile
                if (window.innerWidth <= 768) {
                    const body = document.body;
                    const checkMenuState = () => {
                        try {
                            const data = Alpine.$data(body);
                            if (data && data.mobileMenuOpen) {
                                body.classList.add('menu-open');
                            } else {
                                body.classList.remove('menu-open');
                            }
                        } catch (e) {
                            body.classList.remove('menu-open');
                        }
                    };
                    
                    setInterval(checkMenuState, 200);
                }
            }
        }
        
        // Wait for Alpine.js to load
        if (window.Alpine) {
            initAlpineMenu();
        } else {
            // Check for Alpine.js every 100ms for up to 5 seconds
            const checkAlpine = setInterval(() => {
                if (window.Alpine) {
                    clearInterval(checkAlpine);
                    initAlpineMenu();
                }
            }, 100);
            
            setTimeout(() => clearInterval(checkAlpine), 5000);
        }
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                document.body.classList.remove('menu-open');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
