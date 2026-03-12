@props([
    'current' => false,
])

<a
    {{
        $attributes->class([
            'group relative flex items-center pr-4 pl-6 text-base transition md:text-sm',
            'before:absolute before:inset-y-0 before:left-[-1.5px] before:w-[2px] before:rounded-full',
            'text-primary-500 before:bg-primary-500 font-semibold' => $current && ! settings('appearance.panda'),
            'font-semibold text-gray-900 before:bg-gray-950 dark:text-white dark:before:bg-white' => $current && settings('appearance.panda'),
            'hover:text-gray-900 before:hover:bg-gray-400 dark:hover:text-gray-100 dark:before:hover:bg-gray-600' => ! $current,
        ])
    }}
    {{ $current ? 'data-current' : false }}
    {{ $attributes->has('href') ? 'wire:navigate' : false }}
>
    <x-sidebar.label>{{ $slot }}</x-sidebar.label>
</a>
