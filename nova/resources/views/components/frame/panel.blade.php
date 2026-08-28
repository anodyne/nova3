@props([
    'stacked' => false,
])

<div
    data-slot="frame-panel"
    {{
        $attributes->class([
            'relative rounded-xl border border-gray-200 bg-white bg-clip-padding shadow-xs/5',
            'before:pointer-events-none before:absolute before:inset-0 before:rounded-[calc(var(--radius-xl)-1px)] before:shadow-[0_1px_--theme(--color-black/4%)]',
            'p-5' => ! $stacked,
            'divide-y divide-gray-200 *:p-5' => $stacked,
        ])
    }}
>
    {{ $slot }}
</div>
