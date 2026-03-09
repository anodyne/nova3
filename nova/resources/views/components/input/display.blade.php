@props([
    'label',
    'copyable' => false,
])

<x-input.field>
    <x-label>{{ $label }}</x-label>

    <div @class([
        'relative flex items-center gap-1' => $copyable,
    ])>
        {{ $slot }}

        @if ($copyable)
            <x-button.copy size="sm" inset="top bottom" />
        @endif
    </div>
</x-input.field>
