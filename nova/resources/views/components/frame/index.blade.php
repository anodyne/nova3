<div
    {{
        $attributes->class([
            'relative flex flex-col rounded-2xl bg-gray-50 dark:bg-gray-900 ring-1 ring-inset ring-gray-950/10',
            '*:[[data-slot=frame-panel]+[data-slot=frame-panel]]:mt-1',
        ])
    }}
    data-slot="frame"
>
    {{ $slot }}
</div>