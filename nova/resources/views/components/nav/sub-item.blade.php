@props([
    'active' => false,
])

<a
    @class([
        'group relative -ml-0.5 flex items-center py-1.5 pl-6 pr-4 text-base transition md:text-sm',
        'font-semibold text-primary-500' => $active && ! settings('appearance.panda'),
        'font-semibold text-gray-900 dark:text-white' => $active && settings('appearance.panda'),
        'hover:text-gray-900 dark:hover:text-gray-100' => ! $active,
    ])
    {{ $attributes }}
>
    <div
        @class([
            'absolute -left-[3px] h-2 w-2 rounded-full pt-px ring-4 ring-gray-100 dark:ring-gray-950',
            'hidden bg-gray-400 group-hover:block dark:bg-gray-600' => ! $active,
            'bg-primary-500' => $active && ! settings('appearance.panda'),
            'bg-gray-900 dark:bg-white' => $active && settings('appearance.panda'),
        ])
    ></div>

    <span class="truncate">{{ $slot }}</span>
</a>
