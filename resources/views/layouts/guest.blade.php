<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>AJ Electric</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 relative">
        <!-- Animated Background Elements -->
        <div class="fixed inset-0 -z-10">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-amber-400/20 to-orange-400/20 rounded-full animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-r from-orange-400/20 to-red-400/20 rounded-full animate-bounce"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-yellow-300/10 to-amber-300/10 rounded-full animate-ping"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4 relative z-10">
            <div class="mb-6">
                <a href="/" class="flex items-center justify-center">
                    <div class="h-16 w-16 md:h-20 md:w-20 bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 rounded-3xl flex items-center justify-center animate-pulse shadow-2xl">
                        <svg class="h-8 w-8 md:h-10 md:w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </a>
                <h2 class="text-center mt-4 text-2xl md:text-3xl font-bold bg-gradient-to-r from-amber-600 via-orange-500 to-red-600 bg-clip-text text-transparent">Bijli Wala Bhai</h2>
            </div>

            <div class="w-full sm:max-w-md px-4 sm:px-6 py-6 md:py-8 bg-gradient-to-br from-white to-orange-50/30 backdrop-blur-sm shadow-2xl overflow-hidden rounded-xl border-2 border-orange-200">
                {{ $slot }}
            </div>

            <!-- Back to Home Link -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-orange-700 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Website
                </a>
            </div>
        </div>
    </body>
</html>
