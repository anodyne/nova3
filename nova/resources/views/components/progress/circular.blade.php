@props([
    'percentage' => 0,
    'color' => null,
    'size' => null,
    'showPercent' => true,
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

    $sizeClasses = match ($size) {
        'sm' => 'size-8',
        'md' => 'size-10',
        'lg' => 'size-12',
        'xl' => 'size-16',
        '2xl' => 'size-20',
        default => $size,
    };
@endphp

<div {{ $attributes->class(['relative inline-block aspect-square', $sizeClasses]) }}>
    <svg viewBox="0 0 100 100" fill="none" class="h-full w-full">
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

    @if ($showPercent)
        <div
            @class([
                'absolute inset-0 flex items-center justify-center text-gray-900 dark:text-white',
                match ($size) {
                    'md', 'lg' => 'text-xs font-medium',
                    default => 'text-sm font-medium',
                },
            ])
        >
            {{ $percentage }}%
        </div>
    @endif
</div>
