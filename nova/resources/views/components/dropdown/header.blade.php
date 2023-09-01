@props([
    'icon' => false,
])

<div
    {{ $attributes->merge(['class' => 'block px-2 pt-3 pb-1.5 text-sm text-gray-400 dark:text-gray-500 font-medium']) }}
    role="menuitem"
>
    @if ($icon)
        <x-icon :name="$icon" size="sm" class="mr-3 text-gray-400 dark:text-gray-500"></x-icon>
    @endif

    {{ $slot }}
</div>
