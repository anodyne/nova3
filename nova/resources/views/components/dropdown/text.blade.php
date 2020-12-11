@props([
    'icon' => false,
])

<div {{ $attributes->merge(['class' => 'block px-4 py-3 text-sm']) }} role="menuitem">
    @if ($icon)
        @icon($icon, 'mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500')
    @endif

    {{ $slot }}
</div>