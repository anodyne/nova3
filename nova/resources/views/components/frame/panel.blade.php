<div
    {{
        $attributes->class([
            'relative rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 bg-clip-padding',
            'before:pointer-events-none before:absolute before:inset-0 before:rounded-[calc(theme(radius.xl)-1px)] before:shadow-[0_1px_theme(colors.black/4%)] dark:before:shadow-[0_-1px_theme(colors.white/6%)]',
        ])
    }}
    data-slot="frame-panel"
>
    {{ $slot }}
</div>