@props([
    'color' => 'gray',
    'size' => 'md',
    'leading' => false,
    'trailing' => false,
    'group' => false,
    'border' => false,
])

<span @class([
    'inline-flex items-center rounded-full font-medium',
    'space-x-1.5' => !$group,
    'space-x-3' => $group,
    'px-2 py-0.5 text-xs' => $size === 'sm' && !$group,
    'px-2.5 py-0.5 text-sm' => $size === 'md' && !$group,
    'px-3 py-1 text-sm' => $size === 'lg' && !$group,
    'px-3.5 py-1 text-sm' => $group,

    'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200' => $color === 'gray-subtle' && $border === false,
    'bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200' => $color === 'gray' && $border === false,
    'bg-gray-600 dark:bg-gray-700 text-white dark:text-gray-100' => $color === 'gray-bold' && $border === false,
    'bg-transparent border-[1.5px] border-gray-600 dark:border-gray-800 text-gray-700 dark:text-gray-200' => $color === 'gray-subtle' && $border === true,
    'bg-gray-50 dark:bg-gray-900 border-[1.5px] border-gray-600 text-gray-700 dark:text-gray-200' => ($color === 'gray' || $color === 'gray-bold') && $border === true,

    'bg-white dark:bg-gray-800 text-primary-700 dark:text-primary-200' => $color === 'primary-subtle' && $border === false,
    'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-200' => $color === 'primary' && $border === false,
    'bg-primary-600 dark:bg-primary-700 text-white dark:text-primary-100' => $color === 'primary-bold' && $border === false,
    'bg-transparent border-[1.5px] border-primary-600 dark:border-primary-800 text-primary-700 dark:text-primary-200' => $color === 'primary-subtle' && $border === true,
    'bg-primary-50 dark:bg-primary-900 border-[1.5px] border-primary-600 text-primary-700 dark:text-primary-200' => ($color === 'primary' || $color === 'primary-bold') && $border === true,

    'bg-white dark:bg-gray-800 text-success-700 dark:text-success-200' => $color === 'success-subtle' && $border === false,
    'bg-success-100 dark:bg-success-900 text-success-700 dark:text-success-200' => $color === 'success' && $border === false,
    'bg-success-600 dark:bg-success-700 text-white dark:text-success-100' => $color === 'success-bold' && $border === false,
    'bg-transparent border-[1.5px] border-success-600 dark:border-success-800 text-success-700 dark:text-success-200' => $color === 'success-subtle' && $border === true,
    'bg-success-50 dark:bg-success-900 border-[1.5px] border-success-600 text-success-700 dark:text-success-200' => ($color === 'success' || $color === 'success-bold') && $border === true,

    'bg-white dark:bg-gray-800 text-warning-700 dark:text-warning-200' => $color === 'warning-subtle' && $border === false,
    'bg-warning-100 dark:bg-warning-900 text-warning-700 dark:text-warning-200' => $color === 'warning' && $border === false,
    'bg-warning-600 dark:bg-warning-700 text-white dark:text-warning-100' => $color === 'warning-bold' && $border === false,
    'bg-transparent border-[1.5px] border-warning-600 dark:border-warning-800 text-warning-700 dark:text-warning-200' => $color === 'warning-subtle' && $border === true,
    'bg-warning-50 dark:bg-warning-900 border-[1.5px] border-warning-600 text-warning-700 dark:text-warning-200' => ($color === 'warning' || $color === 'warning-bold') && $border === true,

    'bg-white dark:bg-gray-800 text-error-700 dark:text-error-200' => $color === 'error-subtle' && $border === false,
    'bg-error-100 dark:bg-error-900 text-error-700 dark:text-error-200' => $color === 'error' && $border === false,
    'bg-error-600 dark:bg-error-700 text-white dark:text-error-100' => $color === 'error-bold' && $border === false,
    'bg-transparent border-[1.5px] border-error-600 dark:border-error-800 text-error-700 dark:text-error-200' => $color === 'error-subtle' && $border === true,
    'bg-error-50 dark:bg-error-900 border-[1.5px] border-error-600 text-error-700 dark:text-error-200' => ($color === 'error' || $color === 'error-bold') && $border === true,

    'bg-white dark:bg-gray-800 text-info-700 dark:text-info-200' => $color === 'info-subtle' && $border === false,
    'bg-info-100 dark:bg-info-900 text-info-700 dark:text-info-200' => $color === 'info' && $border === false,
    'bg-info-600 dark:bg-info-700 text-white dark:text-info-100' => $color === 'info-bold' && $border === false,
    'bg-transparent border-[1.5px] border-info-600 dark:border-info-800 text-info-700 dark:text-info-200' => $color === 'info-subtle' && $border === true,
    'bg-info-50 dark:bg-info-900 border-[1.5px] border-info-600 text-info-700 dark:text-info-200' => ($color === 'info' || $color === 'info-bold') && $border === true,
])>
    @if ($leading)
        <div class="shrink-0 inline-flex items-center">
            <div @class([
                'inline-flex items-center',
                '-ml-2.5' => $group,
            ])>
                {{ $leading }}
            </div>
        </div>
    @endif

    <span class="inline-flex items-center">{{ $slot }}</span>

    @if ($trailing)
        <div class="shrink-0 inline-flex items-center">
            <div @class([
                'inline-flex items-center',
                '-mr-2.5' => $group,
            ])>
                {{ $trailing }}
            </div>
        </div>
    @endif
</span>
