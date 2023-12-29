<p
    data-slot="error"
    @class([
        'text-base/6 text-danger-600 data-[disabled]:opacity-50 sm:text-sm/6 dark:text-danger-500',
        '[&+[data-slot=description]]:mt-4',
        '[&+[data-slot=error]]:mt-4',
        '[&+[data-slot=warning]]:mt-4',
        $attributes->get('class'),
    ])
>
    {{ $slot }}
</p>
