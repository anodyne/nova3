@props([
    'percentage' => 0,
    'color' => null,
])

@php
    $strokeWidth = 12;
    $radius = sprintf('%dpx', $strokeWidth / 2);

    $color = ! is_null($color)
        ? $color
        : match (true) {
            $percentage < 50 => 'danger',
            $percentage < 75 => 'warning',
            default => 'primary',
        };
@endphp

<svg viewBox="0 0 100 100" fill="none" {{ $attributes }}>
    <circle
        cx="50%"
        cy="50%"
        r="calc(50% - {{ $radius }})"
        stroke-width="{{ $strokeWidth }}"
        class="stroke-gray-950/10 dark:stroke-white/10"
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
        @class([
            match ($color) {
                'danger' => 'stroke-danger-500',
                'info' => 'stroke-info-500',
                'success' => 'stroke-success-500',
                'warning' => 'stroke-warning-500',
                default => 'stroke-primary-500',
            },
        ])
    />
</svg>
