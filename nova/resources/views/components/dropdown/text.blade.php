@props([
    'icon' => false,
])

<div {{ $attributes->merge(['class' => 'block px-4 py-3 text-sm text-gray-500 dark:text-gray-400']) }} role="menuitem">
    @if ($icon)
        @icon($icon, 'mr-3 h-5 w-5 text-gray-500')
    @endif

    {{ $slot }}
</div>
