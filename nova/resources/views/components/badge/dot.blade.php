@props([
    'size' => 'sm',
])

@php
    $sizes = match ($size) {
        'sm' => [
            'wh' => 8,
            'c' => 4,
            'r' => 2.5,
        ],
        default => [
            'wh' => 10,
            'c' => 5,
            'r' => 4,
        ],
    };
@endphp

<svg
    width="{{ $sizes['wh'] }}"
    height="{{ $sizes['wh'] }}"
    viewBox="0 0 {{ $sizes['wh'] }} {{ $sizes['wh'] }}"
    fill="none"
    {{ $attributes }}
>
    <circle
        cx="{{ $sizes['c'] }}"
        cy="{{ $sizes['c'] }}"
        r="{{ $sizes['r'] }}"
        fill="currentColor"
        stroke="currentColor"
    />
</svg>
