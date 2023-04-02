@props([
    'active' => false,
])

<a
    @class([
        'rounded-md py-2 px-3 inline-flex items-center text-sm font-medium transition',
        'text-primary-600 dark:text-primary-400 bg-primary-100/75 dark:bg-primary-900/40' => $active,
        'hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100' => ! $active,
    ])
    {{ $attributes }}
>
    {{ $slot }}
</a>
