<div
    data-slot="field"
    {{
        $attributes->class([
            // Base layout
            'grid grid-cols-[1.125rem_1fr] items-center gap-x-4 gap-y-1 sm:grid-cols-[1rem_1fr]',

            // Control layout
            '[&>[data-slot=control]]:col-start-1 [&>[data-slot=control]]:row-start-1 [&>[data-slot=control]]:justify-self-center',

            // Label layout
            '[&>[data-slot=label]]:col-start-2 [&>[data-slot=label]]:row-start-1 [&>[data-slot=label]]:justify-self-start',

            // Description layout
            '[&>[data-slot=description]]:col-start-2 [&>[data-slot=description]]:row-start-2',

            // With description
            '[&_[data-slot=label]]:has-[[data-slot=description]]:font-medium',
        ])
    }}
>
    {{ $slot }}
</div>
