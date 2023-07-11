@props([
    'color' => 'gray',
    'size' => 'md',
    'leading' => false,
    'trailing' => false,
    'group' => false,
    'border' => false,
])

<span
    @class([
        'inline-flex items-center rounded-full font-medium',
        'space-x-1.5' => ! $group,
        'space-x-3' => $group,
        'px-2 py-0.5 text-xs' => $size === 'sm' && ! $group,
        'px-2.5 py-0.5 text-sm' => $size === 'md' && ! $group,
        'px-3 py-1 text-sm' => $size === 'lg' && ! $group,
        'px-3.5 py-1 text-sm' => $group,

        'bg-white text-gray-700 dark:bg-gray-800 dark:text-gray-200' => $color === 'gray-subtle' && $border === false,
        'bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-200' => $color === 'gray' && $border === false,
        'bg-gray-600 text-white dark:bg-gray-700 dark:text-gray-100' => $color === 'gray-bold' && $border === false,
        'border-[1.5px] border-gray-600 bg-transparent text-gray-700 dark:border-gray-800 dark:text-gray-200' => $color === 'gray-subtle' && $border === true,
        'border-[1.5px] border-gray-600 bg-gray-50 text-gray-700 dark:bg-gray-900 dark:text-gray-200' => ($color === 'gray' || $color === 'gray-bold') && $border === true,

        'bg-white text-primary-700 dark:bg-gray-800 dark:text-primary-200' => $color === 'primary-subtle' && $border === false,
        'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-200' => $color === 'primary' && $border === false,
        'bg-primary-600 text-white dark:bg-primary-700 dark:text-primary-100' => $color === 'primary-bold' && $border === false,
        'border-[1.5px] border-primary-600 bg-transparent text-primary-700 dark:border-primary-800 dark:text-primary-200' => $color === 'primary-subtle' && $border === true,
        'border-[1.5px] border-primary-600 bg-primary-50 text-primary-700 dark:bg-primary-900 dark:text-primary-200' => ($color === 'primary' || $color === 'primary-bold') && $border === true,

        'bg-white text-success-700 dark:bg-gray-800 dark:text-success-200' => $color === 'success-subtle' && $border === false,
        'bg-success-100 text-success-700 dark:bg-success-900 dark:text-success-200' => $color === 'success' && $border === false,
        'bg-success-600 text-white dark:bg-success-700 dark:text-success-100' => $color === 'success-bold' && $border === false,
        'border-[1.5px] border-success-600 bg-transparent text-success-700 dark:border-success-800 dark:text-success-200' => $color === 'success-subtle' && $border === true,
        'border-[1.5px] border-success-600 bg-success-50 text-success-700 dark:bg-success-900 dark:text-success-200' => ($color === 'success' || $color === 'success-bold') && $border === true,

        'bg-white text-warning-700 dark:bg-gray-800 dark:text-warning-200' => $color === 'warning-subtle' && $border === false,
        'bg-warning-100 text-warning-700 dark:bg-warning-900 dark:text-warning-200' => $color === 'warning' && $border === false,
        'bg-warning-600 text-white dark:bg-warning-700 dark:text-warning-100' => $color === 'warning-bold' && $border === false,
        'border-[1.5px] border-warning-600 bg-transparent text-warning-700 dark:border-warning-800 dark:text-warning-200' => $color === 'warning-subtle' && $border === true,
        'border-[1.5px] border-warning-600 bg-warning-50 text-warning-700 dark:bg-warning-900 dark:text-warning-200' => ($color === 'warning' || $color === 'warning-bold') && $border === true,

        'bg-white text-danger-700 dark:bg-gray-800 dark:text-danger-200' => $color === 'danger-subtle' && $border === false,
        'bg-danger-100 text-danger-700 dark:bg-danger-900 dark:text-danger-200' => $color === 'danger' && $border === false,
        'bg-danger-600 text-white dark:bg-danger-700 dark:text-danger-100' => $color === 'danger-bold' && $border === false,
        'border-[1.5px] border-danger-600 bg-transparent text-danger-700 dark:border-danger-800 dark:text-danger-200' => $color === 'danger-subtle' && $border === true,
        'border-[1.5px] border-danger-600 bg-danger-50 text-danger-700 dark:bg-danger-900 dark:text-danger-200' => ($color === 'danger' || $color === 'danger-bold') && $border === true,

        'bg-white text-info-700 dark:bg-gray-800 dark:text-info-200' => $color === 'info-subtle' && $border === false,
        'bg-info-100 text-info-700 dark:bg-info-900 dark:text-info-200' => $color === 'info' && $border === false,
        'bg-info-600 text-white dark:bg-info-700 dark:text-info-100' => $color === 'info-bold' && $border === false,
        'border-[1.5px] border-info-600 bg-transparent text-info-700 dark:border-info-800 dark:text-info-200' => $color === 'info-subtle' && $border === true,
        'border-[1.5px] border-info-600 bg-info-50 text-info-700 dark:bg-info-900 dark:text-info-200' => ($color === 'info' || $color === 'info-bold') && $border === true,
    ])
>
    @if ($leading)
        <div class="inline-flex shrink-0 items-center">
            <div
                @class([
                    'inline-flex items-center',
                    '-ml-2.5' => $group,
                ])
            >
                {{ $leading }}
            </div>
        </div>
    @endif

    <span class="inline-flex items-center">{{ $slot }}</span>

    @if ($trailing)
        <div class="inline-flex shrink-0 items-center">
            <div
                @class([
                    'inline-flex items-center',
                    '-mr-2.5' => $group,
                ])
            >
                {{ $trailing }}
            </div>
        </div>
    @endif
</span>
