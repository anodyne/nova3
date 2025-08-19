@props([
    'type' => 'square',
    'variant' => null,
    'size' => 'sm',
    'color' => 'gray',
    'leading' => false,
    'trailing' => false,
])

@php
    $colorClasses = match ($color) {
        'primary' => 'bg-primary-50 dark:bg-primary-900 dark:ring-primary-700 dark:text-primary-300 text-primary-700 ring-primary-200',
        'danger' => 'bg-danger-50 dark:bg-danger-900 dark:ring-danger-700 dark:text-danger-300 text-danger-700 ring-danger-200',
        'info' => 'bg-info-50 dark:bg-info-900 dark:ring-info-700 dark:text-info-300 text-info-700 ring-info-200',
        'success' => 'bg-success-50 dark:bg-success-900 dark:ring-success-700 dark:text-success-300 text-success-700 ring-success-200',
        'warning' => 'bg-warning-50 dark:bg-warning-900 dark:ring-warning-700 dark:text-warning-300 text-warning-700 ring-warning-200',
        default => 'bg-gray-50 text-gray-700 ring-gray-200 dark:bg-gray-900 dark:text-gray-300 dark:ring-gray-700',
    };

    $addonClasses = match ($color) {
        'primary' => 'text-primary-500 dark:text-primary-300',
        'danger' => 'text-danger-500 dark:text-danger-300',
        'info' => 'text-info-500 dark:text-info-300',
        'success' => 'text-success-500 dark:text-success-300',
        'warning' => 'text-warning-500 dark:text-warning-300',
        default => 'text-gray-500 dark:text-gray-300',
    };
@endphp

<span
    data-slot="badge"
    data-nova-badge
    @if ($variant === 'inset')
        data-nova-badge-inset
    @endif
    @class([
        'inline-flex size-max items-center font-medium tracking-normal whitespace-nowrap tabular-nums ring-1 ring-inset',

        match ($type) {
            // Square badge
            'square' => Arr::toCssClasses([
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
                    'md' => 'rounded-md text-sm [&_[data-nova-badge-inset]]:rounded-[calc(var(--radius-md)-(--spacing(0.5)))]',
                    'lg' => 'rounded-lg text-sm [&_[data-nova-badge-inset]]:rounded-[calc(var(--radius-lg)-(--spacing(1)))]',
                    default => 'rounded-md text-xs [&_[data-nova-badge-inset]]:rounded-[calc(var(--radius-md)-(--spacing(0.5)))]',
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
                    'md' => 'rounded-md text-sm [&_[data-nova-badge-inset]]:rounded-[calc(var(--radius-md)-(--spacing(0.5)))]',
                    'lg' => 'rounded-lg text-sm [&_[data-nova-badge-inset]]:rounded-[calc(var(--radius-lg)-(--spacing(1)))]',
                    default => 'rounded-md text-xs [&_[data-nova-badge-inset]]:rounded-[calc(var(--radius-md)-(--spacing(0.5)))]',
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

        '[&_[data-nova-badge-inset]]:bg-white',
    ])
>
    @if ($leading)
        <div
            @class([
                'me-2',
                match ($type) {
                    'square' => match ($size) {
                        'md' => '-ms-1.5',
                        'lg' => '-ms-1.5',
                        default => '-ms-1',
                    },
                    'modern' => match ($size) {
                        'md' => '-ms-1.5',
                        'lg' => '-ms-1.5',
                        default => '-ms-1',
                    },
                    default => match ($size) {
                        'md' => '-ms-2',
                        'lg' => '-ms-2',
                        default => '-ms-1.5',
                    }
                },
            ])
        >
            {{ $leading }}
        </div>
    @endif

    @if ($variant === 'dot')
        <x-badge.dot :class="$addonClasses"></x-badge.dot>
    @endif

    {{ $slot }}

    @if ($trailing)
        <div
            @class([
                'ms-2',
                match ($type) {
                    'square' => match ($size) {
                        'md' => '-me-1.5',
                        'lg' => '-me-1.5',
                        default => '-me-1',
                    },
                    'modern' => match ($size) {
                        'md' => '-me-1.5',
                        'lg' => '-me-1.5',
                        default => '-me-1',
                    },
                    default => match ($size) {
                        'md' => '-me-2',
                        'lg' => '-me-2',
                        default => '-me-1.5',
                    }
                },
            ])
        >
            {{ $trailing }}
        </div>
    @endif
</span>
