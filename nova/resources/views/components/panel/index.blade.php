@props([
    'well' => false,
    'noShadow' => false,
])

<div
    data-slot="panel"
    {{
        $attributes->class([
            'isolate rounded-lg has-[&[data-slot=panel]]:rounded-xl',
            'bg-white ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-gray-950/10' => ! $well,
            'bg-gray-950/[.04] ring-1 ring-inset ring-gray-950/[.025] dark:bg-gray-900 dark:ring-white/5' => $well,
            'has-[>[data-slot=panel]]:p-1.5' => $well,
            'shadow' => ! $well && ! $noShadow,
        ])
    }}
>
    {{ $slot }}
</div>
