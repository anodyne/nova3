<div
    data-slot="description"
    @class([
        'text-base/6 text-gray-500 data-[disabled]:opacity-50 dark:text-gray-400 sm:text-sm/6',
        '[&+[data-slot=description]]:mt-4',
        '[&+[data-slot=error]]:mt-4',
        '[&+[data-slot=warning]]:mt-4',
        '[&+[data-slot=info]]:mt-4',
        $attributes->get('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</div>
