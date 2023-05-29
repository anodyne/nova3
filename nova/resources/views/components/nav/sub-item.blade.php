@props([
    'active' => false,
])

<a
    @class([
        'group -ml-0.5 px-3 py-1 flex border-l-2 items-center text-base md:text-sm transition',
        'text-primary-500 border-primary-400 dark:border-primary-500 font-semibold' => $active,
        'hover:text-gray-900 dark:hover:text-gray-100 hover:border-gray-400 dark:hover:border-gray-600 border-transparent' => ! $active,
    ])
    {{ $attributes }}
>
    <span class="truncate">{{ $slot }}</span>
</a>
