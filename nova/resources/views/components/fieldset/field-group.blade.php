@props([
    'constrained' => false,
    'constrainedLg' => false,
])

<div
    data-slot="control"
    @class([
        'w-full space-y-8',
        'max-w-md' => $constrained,
        'max-w-xl' => $constrainedLg,
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</div>
