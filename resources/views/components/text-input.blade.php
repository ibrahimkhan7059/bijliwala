@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-2 border-orange-200 focus:border-orange-500 focus:ring-orange-500 rounded-lg shadow-sm bg-white/80 backdrop-blur-sm px-4 py-2.5 text-gray-900 placeholder-gray-500 transition-all']) }}>
