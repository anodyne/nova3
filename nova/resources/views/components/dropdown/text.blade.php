@props([
    'icon' => false,
])

<div
    {{ $attributes->merge(['class' => 'block px-4 py-3 text-base md:text-sm text-gray-700 dark:text-gray-300']) }}
    role="menuitem"
>
    @if ($icon)
        <x-icon :name="$icon" size="sm" class="mr-3 text-gray-500 dark:text-gray-400"></x-icon>
    @endif

    {{ $slot }}
</div>
