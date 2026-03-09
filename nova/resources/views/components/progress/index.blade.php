@props([
    'percentage' => 0,
    'color' => null,
    'size' => 'sm',
])

@php
    $color = ! is_null($color)
        ? $color
        : match (true) {
            $percentage < 50 => 'danger',
            $percentage < 75 => 'warning',
            default => 'primary',
        };
@endphp

<div
    @class([
        'relative z-[1] w-full overflow-hidden rounded-full bg-gray-950/10 dark:bg-white/15',
        match ($size) {
            'xs' => 'h-1',
            'md' => 'h-3',
            default => 'h-2',
        },
    ])
>
    <div
        @class([
            'absolute z-[2] rounded-full',
            'ring-2 ring-white dark:ring-gray-950' => true,
            'w-2' => $percentage === 0,
            match ($color) {
                'danger' => 'bg-danger-500',
                'info' => 'bg-info-500',
                'success' => 'bg-success-500',
                'warning' => 'bg-warning-500',
                default => 'bg-primary-500',
            },
            match ($size) {
                'xs' => 'h-1',
                'md' => 'h-3',
                default => 'h-2',
            },
        ])
        @if ($percentage > 0)
            style="width: {{ $percentage }}%"
        @endif
    ></div>
</div>
