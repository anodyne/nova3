@props([
    'percentage' => 0,
])

@php
    $strokeWidth = 12;
    $radius = sprintf('%dpx', $strokeWidth / 2);
@endphp

<svg viewBox="0 0 100 100" fill="none" {{ $attributes }}>
    <circle
        cx="50%"
        cy="50%"
        r="calc(50% - {{ $radius }})"
        stroke-width="{{ $strokeWidth }}"
        class="stroke-gray-300 dark:stroke-gray-700"
    />

    <circle
        cx="50%"
        cy="50%"
        r="calc(50% - {{ $radius }})"
        stroke-width="{{ $strokeWidth }}"
        pathLength="100"
        stroke-dasharray="100"
        stroke-dashoffset="{{ 100 - $percentage }}"
        stroke-linecap="round"
        transform="rotate(-90)"
        transform-origin="center"
        class="stroke-primary-500"
    />
</svg>
