<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wider hover:from-amber-600 hover:via-orange-600 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 active:scale-95 transform transition-all duration-200 shadow-lg hover:shadow-xl']) }}>
    {{ $slot }}
</button>
