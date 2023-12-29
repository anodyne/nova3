<div
    data-slot="description"
    @class([
        'text-base/6 text-gray-500 data-[disabled]:opacity-50 sm:text-sm/6 dark:text-gray-400',
        '[&+[data-slot=description]]:mt-4',
        '[&+[data-slot=error]]:mt-4',
        '[&+[data-slot=warning]]:mt-4',
        $attributes->get('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</div>
