<div
    data-slot="control"
    @class([
        'space-y-3 [&_[data-slot=label]]:font-normal',
        'has-[[data-slot=description]]:space-y-6 [&_[data-slot=label]]:has-[[data-slot=description]]:font-medium',
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</div>
