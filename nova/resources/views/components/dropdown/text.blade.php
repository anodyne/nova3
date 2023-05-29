@props([
    'icon' => false,
])

<div {{ $attributes->merge(['class' => 'block px-4 py-3 text-sm text-gray-500 dark:text-gray-400']) }} role="menuitem">
    @if ($icon)
        <x-icon :name="$icon" size="sm" class="mr-3 text-gray-500"></x-icon>
    @endif

    {{ $slot }}
</div>
