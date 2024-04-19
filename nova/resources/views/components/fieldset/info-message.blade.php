<p
    data-slot="info"
    @class([
        'text-base/6 text-info-600 data-[disabled]:opacity-50 dark:text-info-500 sm:text-sm/6',
        '[&+[data-slot=description]]:mt-4',
        '[&+[data-slot=error]]:mt-4',
        '[&+[data-slot=warning]]:mt-4',
        '[&+[data-slot=info]]:mt-4',
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</p>
