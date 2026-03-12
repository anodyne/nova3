<div
    {{
        $attributes->class([
            '[&>*+[data-slot=control]]:mt-6 [&>[data-slot=text]]:mt-1',
        ])
    }}
>
    {{ $slot }}
</div>
