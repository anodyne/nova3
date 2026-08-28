<footer
    data-slot="frame-panel-footer"
    {{
        $attributes->class([
            'px-5 py-4',
            'text-gray-500 text-sm',
        ])
    }}
>
    {{ $slot }}
</footer>
