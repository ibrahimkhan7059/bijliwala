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
    
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'AJelectric') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        
        @media (max-width: 1023px) {
            body.sidebar-open {
                overflow: hidden;
                position: fixed;
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 font-sans" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div x-show="sidebarOpen || window.innerWidth >= 1024"
             x-cloak
             @click.away="if(window.innerWidth < 1024) sidebarOpen = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 z-[100] w-64 sm:w-72 bg-gradient-to-br from-white via-orange-50 to-amber-50 shadow-2xl border-r-2 border-orange-200 lg:translate-x-0 lg:static lg:inset-0 lg:z-auto overflow-y-auto" 
             id="sidebar">
            <div class="flex items-center justify-between h-16 md:h-20 bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 shadow-lg px-4">
                <div class="flex items-center">
                    <div class="h-8 w-8 md:h-10 md:w-10 bg-white rounded-xl flex items-center justify-center mr-2 md:mr-3 shadow-lg animate-pulse">
                        <svg class="h-5 w-5 md:h-6 md:w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-base md:text-lg lg:text-xl font-bold text-white leading-tight">Admin Panel</span>
                        <span class="text-[9px] md:text-[10px] text-yellow-100">AJelectric</span>
                    </div>
                </div>
                <!-- Mobile close button -->
                <button @click="sidebarOpen = false" 
                        class="lg:hidden p-2 text-white hover:bg-white/20 rounded-lg transition-colors"
                        aria-label="Close sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="mt-4 px-2 pb-6">
                <div class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                        @click="sidebarOpen = false"
                        class="group flex items-center px-3 py-2.5 md:py-3 text-xs sm:text-sm font-semibold rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-700' }} transition-all">
                        <svg class="mr-2 md:mr-3 h-4 w-4 md:h-5 md:w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        Dashboard
                    </a>

                    <!-- Products -->
                    <a href="{{ route('admin.products.index') }}" 
                        @click="sidebarOpen = false"
                        class="group flex items-center px-3 py-2.5 md:py-3 text-xs sm:text-sm font-semibold rounded-xl {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-700' }} transition-all">
                        <svg class="mr-2 md:mr-3 h-4 w-4 md:h-5 md:w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Products
                    </a>

                    <!-- Categories -->
                    <a href="{{ route('admin.categories.index') }}" 
                        @click="sidebarOpen = false"
                        class="group flex items-center px-3 py-2.5 md:py-3 text-xs sm:text-sm font-semibold rounded-xl {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-700' }} transition-all">
                        <svg class="mr-2 md:mr-3 h-4 w-4 md:h-5 md:w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Categories
                    </a>

                    <!-- Blog -->
                    <a href="{{ route('admin.blogs.index') }}" 
                        @click="sidebarOpen = false"
                        class="group flex items-center px-3 py-2.5 md:py-3 text-xs sm:text-sm font-semibold rounded-xl {{ request()->routeIs('admin.blogs.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-700' }} transition-all">
                        <svg class="mr-2 md:mr-3 h-4 w-4 md:h-5 md:w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Blog
                    </a>

                    <!-- Orders -->
                    <a href="{{ route('admin.orders.index') }}" 
                        @click="sidebarOpen = false"
                        class="group flex items-center px-3 py-2.5 md:py-3 text-xs sm:text-sm font-semibold rounded-xl {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-700' }} transition-all">
                        <svg class="mr-2 md:mr-3 h-4 w-4 md:h-5 md:w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Orders
                    </a>

                    <!-- Customers -->
                    <a href="{{ route('admin.customers.index') }}" 
                        @click="sidebarOpen = false"
                        class="group flex items-center px-3 py-2.5 md:py-3 text-xs sm:text-sm font-semibold rounded-xl {{ request()->routeIs('admin.customers.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-700' }} transition-all">
                        <svg class="mr-2 md:mr-3 h-4 w-4 md:h-5 md:w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Customers
                    </a>

                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <!-- Settings -->
                        <a href="{{ route('admin.settings.index') }}" 
                            @click="sidebarOpen = false"
                            class="group flex items-center px-3 py-2.5 md:py-3 text-xs sm:text-sm font-semibold rounded-xl {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-700' }} transition-all">
                            <svg class="mr-2 md:mr-3 h-4 w-4 md:h-5 md:w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Settings
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0 min-w-0 relative z-0">
            <!-- Top Navigation -->
            <div class="bg-gradient-to-r from-white via-orange-50/30 to-white shadow-lg border-b-2 border-orange-200 flex-shrink-0 relative z-50">
                <div class="px-3 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-14 md:h-16">
                        <!-- Mobile menu button -->
                        <div class="flex items-center lg:hidden">
                            <button @click="sidebarOpen = !sidebarOpen" 
                                    type="button" 
                                    class="inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-orange-600 hover:bg-orange-50 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    aria-label="Toggle menu">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>

                        <!-- Page Title -->
                        <div class="flex items-center flex-1 lg:flex-none justify-center lg:justify-start lg:ml-0">
                            <h1 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-gray-900 truncate px-2">@yield('page-title', 'Dashboard')</h1>
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center space-x-2 md:space-x-4">
                            <!-- Notifications -->
                            <button class="p-2 text-gray-500 hover:text-orange-600 hover:bg-orange-50 rounded-lg relative transition-all">
                                <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                            </button>

                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 hover:bg-orange-50 px-2 py-1 transition-all">
                                    <div class="h-8 w-8 md:h-10 md:w-10 rounded-full bg-gradient-to-r from-amber-500 to-orange-600 flex items-center justify-center shadow-lg">
                                        <span class="text-sm md:text-base font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="ml-2 text-gray-700 font-semibold hidden md:block">{{ Auth::user()->name }}</span>
                                    <svg class="ml-1 h-4 w-4 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                    class="absolute right-0 mt-2 w-56 bg-gradient-to-br from-white to-orange-50 rounded-xl shadow-2xl py-2 z-50 border-2 border-orange-200">
                                    <div class="px-4 py-3 border-b border-orange-100">
                                        <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-600">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-700 transition-all">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        View Website
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 hover:text-orange-700 transition-all">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profile Settings
                                    </a>
                                    <div class="border-t-2 border-orange-100 my-2"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full text-left px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition-all">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto">
                <div class="py-4 sm:py-6">
                    <div class="w-full px-4 sm:px-6 lg:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-cloak
         @click="sidebarOpen = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 lg:hidden z-[90]"></div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // Handle body scroll lock when sidebar opens/closes - only on mobile
        document.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth < 1024) {
                const checkAlpine = setInterval(() => {
                    if (window.Alpine) {
                        clearInterval(checkAlpine);
                        
                        const body = document.body;
                        const checkSidebarState = () => {
                            try {
                                const data = Alpine.$data(body);
                                if (data && data.sidebarOpen) {
                                    body.classList.add('sidebar-open');
            } else {
                                    body.classList.remove('sidebar-open');
                                }
                            } catch (e) {
                                body.classList.remove('sidebar-open');
                            }
                        };
                        
                        setInterval(checkSidebarState, 200);
                    }
                }, 100);
                
                setTimeout(() => clearInterval(checkAlpine), 5000);
            }
        });
        
        // Remove sidebar-open class on window resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                document.body.classList.remove('sidebar-open');
            }
        });
    </script>
</body>
</html>
