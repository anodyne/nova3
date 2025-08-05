@props([
    'type' => 'pill',
    'variant' => null,
    'size' => 'sm',
    'color' => 'gray',
])

@php
    $colorClasses = match ($color) {
        'primary' => 'bg-primary-50 text-primary-700 ring-primary-200',
        'danger' => 'bg-danger-50 text-danger-700 ring-danger-200',
        'info' => 'bg-info-50 text-info-700 ring-info-200',
        'success' => 'bg-success-50 text-success-700 ring-success-200',
        'warning' => 'bg-warning-50 text-warning-700 ring-warning-200',
        default => 'bg-gray-50 text-gray-700 ring-gray-200',
    };

    $addonClasses = match ($color) {
        'primary' => 'text-primary-500',
        'danger' => 'text-danger-500',
        'info' => 'text-info-500',
        'success' => 'text-success-500',
        'warning' => 'text-warning-500',
        default => 'text-gray-500',
    };
@endphp

<span
    data-slot="badge"
    @class([
        'nv-badge flex size-max items-center font-medium whitespace-nowrap tabular-nums ring-1 ring-inset',

        match ($type) {
            // Color badge
            'color' => Arr::toCssClasses([
                match ($variant) {
                    'dot' => match ($size) {
                        'md' => 'gap-1 px-2 py-0.5',
                        'lg' => 'gap-1.5 px-2.5 py-1',
                        default => 'gap-1 px-1.5 py-0.5',
                    },
                    'icon' => match ($size) {
                        'md' => 'p-1.5 *:data-[slot=icon]:size-4',
                        'lg' => 'p-2 *:data-[slot=icon]:size-4',
                        default => 'p-1.25 *:data-[slot=icon]:size-4',
                    },
                    default => match ($size) {
                        'md' => 'px-2 py-0.5',
                        'lg' => 'px-2.5 py-1',
                        default => 'px-1.5 py-0.5',
                    },
                },
                match ($size) {
                    'md' => 'rounded-md text-sm',
                    'lg' => 'rounded-lg text-sm',
                    default => 'rounded-md text-xs',
                },
                $colorClasses,
            ]),

            // Modern badge
            'modern' => Arr::toCssClasses([
                'shadow-xs',
                match ($variant) {
                    'dot' => match ($size) {
                        'md' => 'gap-1 px-2 py-0.5',
                        'lg' => 'gap-1.5 px-2.5 py-1',
                        default => 'gap-1 px-1.5 py-0.5',
                    },
                    'icon' => match ($size) {
                        'md' => 'p-1.5 *:data-[slot=icon]:size-4',
                        'lg' => 'p-2 *:data-[slot=icon]:size-4',
                        default => 'p-1.25 *:data-[slot=icon]:size-4',
                    },
                    default => match ($size) {
                        'md' => 'px-2 py-0.5',
                        'lg' => 'px-2.5 py-1',
                        default => 'px-1.5 py-0.5',
                    },
                },
                match ($size) {
                    'md' => 'rounded-md text-sm',
                    'lg' => 'rounded-lg text-sm',
                    default => 'rounded-md text-xs',
                },
                'bg-white text-gray-700 ring-gray-200',
            ]),

            // Pill badge
            default => Arr::toCssClasses([
                'rounded-full',
                match ($variant) {
                    'dot' => match ($size) {
                        'md' => 'gap-1.5 py-0.5 pr-2.5 pl-2',
                        'lg' => 'gap-1.5 py-1 pr-3 pl-2.5',
                        default => 'gap-1 py-0.5 pr-2 pl-1.5',
                    },
                    'icon' => match ($size) {
                        'md' => 'p-1.5 *:data-[slot=icon]:size-4',
                        'lg' => 'p-2 *:data-[slot=icon]:size-4',
                        default => 'p-1.25 *:data-[slot=icon]:size-4',
                    },
                    default => match ($size) {
                        'md' => 'px-2.5 py-0.5',
                        'lg' => 'px-3 py-1',
                        default => 'px-2 py-0.5',
                    },
                },
                match ($size) {
                    'md' => 'text-sm',
                    'lg' => 'text-sm',
                    default => 'text-xs',
                },
                $colorClasses,
            ]),
        },
    ])
>
    @if ($variant === 'dot')
        <x-badge.dot :class="$addonClasses"></x-badge.dot>
    @endif

    {{ $slot }}
</span>
