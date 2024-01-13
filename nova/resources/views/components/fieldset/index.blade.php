<div
    @class([
        '[&>*+[data-slot=control]]:mt-6 [&>[data-slot=text]]:mt-1',
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</div>
