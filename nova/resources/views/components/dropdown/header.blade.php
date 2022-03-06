@props([
    'icon' => false,
])

<div {{ $attributes->merge(['class' => 'block px-2 pt-3 pb-1.5 text-xs text-gray-9 uppercase tracking-wide font-semibold']) }} role="menuitem">
    @if ($icon)
        @icon($icon, 'mr-3 h-5 w-5 text-gray-9 group-hover:text-gray-10')
    @endif

    {{ $slot }}
</div>