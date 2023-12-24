@props([
    'size' => 'base',
])

<p
    data-slot="text"
    @class([
        'text-gray-500 dark:text-gray-400',
        match ($size) {
            'sm' => 'text-sm/5 sm:text-xs/5',
            'lg' => 'text-lg/7 sm:text-base/7',
            'xl' => 'text-xl/8 sm:text-lg/8',
            default => 'text-base/6 sm:text-sm/6',
        },
    ])
>
    {{ $slot }}
</p>
