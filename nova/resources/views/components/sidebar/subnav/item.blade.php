@props([
    'active' => false,
])

<a
    {{
        $attributes->class([
            'group relative flex items-center pl-6 pr-4 text-base transition md:text-sm',
            'before:absolute before:inset-y-0 before:left-[-1.5px] before:w-[2px] before:rounded-full',
            'font-semibold text-primary-500 before:bg-primary-500' => $active && ! settings('appearance.panda'),
            'font-semibold text-gray-900 before:bg-gray-950 dark:text-white dark:before:bg-white' => $active && settings('appearance.panda'),
            'hover:text-gray-900 before:hover:bg-gray-400 dark:hover:text-gray-100 dark:before:hover:bg-gray-600' => ! $active,
        ])
    }}
    {{ $active ? 'data-current' : false }}
    {{ $attributes->has('href') ? 'wire:navigate' : false }}
>
    <x-sidebar.label>{{ $slot }}</x-sidebar.label>
</a>
