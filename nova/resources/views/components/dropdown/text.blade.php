@props([
    'icon' => false,
])

<div
    {{ $attributes->class(['block px-4 py-2 text-sm text-white']) }}
>
    @if ($icon)
        <x-icon :name="$icon" size="sm" class="mr-3 text-gray-400"></x-icon>
    @endif

    {{ $slot }}
</div>
