<div
    data-slot="frame"
    {{
        $attributes->class([
            'relative flex flex-col rounded-2xl bg-gray-100 p-1 w-full',
            '*:[[data-slot=frame-panel]+[data-slot=frame-panel]]:mt-1'
        ])
    }}
>
    {{ $slot }}
</div>
