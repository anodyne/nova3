@props([
    'height' => null,
    'width' => null,
    'size' => null,
    'constrained' => false,
    'constrainedLg' => false,
])

<div
    data-slot="container"
    @class([
        'relative w-full',

        match ($size) {
            'none' => 'p-0',
            '2xs' => 'p-1.5',
            'xs' => 'p-3',
            'sm' => 'p-4',
            'md' => 'p-6',
            'lg' => 'p-8',
            'xl' => 'p-12',
            default => null,
        } => filled($size),

        match ($height) {
            'none' => 'py-0',
            '2xs' => 'py-1.5',
            'xs' => 'py-3',
            'sm' => 'py-4',
            'md' => 'py-6',
            'lg' => 'py-8',
            'xl' => 'py-12',
            default => null,
        } => filled($height),

        match ($width) {
            'none' => 'px-0',
            '2xs' => 'px-1.5',
            'xs' => 'px-3',
            'sm' => 'px-4',
            'md' => 'px-6',
            'lg' => 'px-8',
            'xl' => 'px-12',
            default => null,
        } => filled($width),

        'mx-auto max-w-2xl' => $constrained,
        'mx-auto max-w-3xl' => $constrainedLg,
        $attributes->get('class') => $attributes->has('class'),
    ])
    {{ $attributes }}
>
    {{ $slot }}
</div>
