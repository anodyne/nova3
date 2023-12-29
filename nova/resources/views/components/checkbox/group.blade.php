<div
    data-slot="control"
    @class([
        // Basic groups
        'space-y-3',

        // With descriptions
        'has-[[data-slot=description]]:space-y-6 [&_[data-slot=label]]:has-[[data-slot=description]]:font-medium',

        $attributes->get('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</div>
