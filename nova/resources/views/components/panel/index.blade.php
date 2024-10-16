@props([
    'well' => false,
    'noShadow' => false,
])

<div
    data-slot="panel"
    {{
        $attributes->class([
            'rounded-lg has-[&[data-slot=panel]]:rounded-xl',
            'bg-white ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/5' => ! $well,
            'bg-gray-950/[.04] ring-1 ring-inset ring-gray-950/[.025] dark:bg-white/[.04] dark:ring-white/[.025]' => $well,
            'has-[>[data-slot=panel]]:p-1.5' => $well,
            'shadow' => ! $well && ! $noShadow,
        ])
    }}
>
    {{ $slot }}
</div>
