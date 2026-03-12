@props([
    'icon' => false,
])

<div
    {{ $attributes->class(['block px-2 py-1.5 text-sm text-white']) }}
>
    @if ($icon)
        <x-icon :name="$icon" size="sm" class="mr-3 text-gray-400" />
    @endif

    {{ $slot }}
</div>
