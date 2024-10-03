<div
    data-slot="control"
    {{
        $attributes->class([
            // Basic groups
            'space-y-3',

            // With descriptions
            'has-[[data-slot=description]]:space-y-6 [&_[data-slot=label]]:has-[[data-slot=description]]:font-medium',
        ])
    }}
>
    {{ $slot }}
</div>
