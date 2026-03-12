@props([
    'height' => null,
    'width' => null,
    'trailing' => false,
])

@aware(['striped'])

@php
    $height ??= 'sm';
    $width ??= 'md';
@endphp

<x-spacing
    {{
    $attributes
        ->merge([
            'height' => $height,
            'width' => $width,
        ])
}}
>
    <div
        {{
            $attributes->class([
                'flex items-center justify-between',
            ])
        }}
    >
        {{ $slot }}
    </div>

    @if ($trailing)
        {{ $trailing }}
    @endif
</x-spacing>
