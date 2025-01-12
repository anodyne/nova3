@props([
    'percentage' => 0,
    'color' => null,
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

<div class="relative z-[1] h-2 w-full overflow-hidden rounded-full bg-gray-950/10 dark:bg-white/10">
    <div
        @class([
            'absolute z-[2] h-2 rounded-full',
            match ($color) {
                'danger' => 'bg-danger-500',
                'info' => 'bg-info-500',
                'success' => 'bg-success-500',
                'warning' => 'bg-warning-500',
                default => 'bg-primary-500',
            },
        ])
        style="width: {{ $percentage }}%"
    ></div>
</div>
