@props([
    'icon' => false,
])

<div {{ $attributes->merge(['class' => 'block px-2 pt-3 pb-1.5 text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold']) }} role="menuitem">
    @if ($icon)
        @icon($icon, 'mr-3 h-5 w-5 text-gray-400 dark:text-gray-500')
    @endif

    {{ $slot }}
</div>
