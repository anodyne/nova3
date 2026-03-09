@props([
    'constrained' => false,
    'constrainedLg' => false,
])

<div
    data-slot="control"
    {{
        $attributes->class([
            'w-full space-y-8',
            'max-w-md' => $constrained,
            'max-w-xl' => $constrainedLg,
        ])
    }}
>
    {{ $slot }}
</div>
