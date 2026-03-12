@props([
    'variant' => 'gray',
    'weight' => 'normal',
    'as' => 'a',
    'underline' => false,
])

<{{ $as }}
    {{
        $attributes->class([
            'relative inline-flex cursor-pointer items-center justify-center gap-2 focus:outline-hidden',
            match ($variant) {
                'primary' => 'text-primary-500 hover:text-primary-600 dark:hover:text-primary-400',
                'heavy-primary' => 'text-primary-600 dark:text-primary-300 hover:text-primary-700 dark:hover:text-primary-200',
                'danger' => 'text-danger-500 hover:text-danger-600 dark:hover:text-danger-400',
                'warning' => 'text-warning-700 hover:text-warning-800 dark:text-warning-500 dark:hover:text-warning-400',
                'heavy' => 'text-gray-600 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-200',
                'gray-primary' => 'hover:text-primary-500 dark:hover:text-primary-500 text-gray-500 dark:text-gray-400',
                'gray-danger' => 'hover:text-danger-500 dark:hover:text-danger-500 text-gray-500 dark:text-gray-400',
                'subtle' => 'text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400',
                'subtle-primary' => 'hover:text-primary-500 dark:hover:text-primary-500 text-gray-400 dark:text-gray-600',
                'subtle-danger' => 'hover:text-danger-500 dark:hover:text-danger-500 text-gray-400 dark:text-gray-600',
                default => 'text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300',
            },
            match ($weight) {
                'medium' => 'font-medium',
                'semibold' => 'font-semibold',
                'bold' => 'font-bold',
                default => null,
            },
            'underline' => $underline,
        ])
    }}
>
    {{ $slot }}
</{{ $as }}>
