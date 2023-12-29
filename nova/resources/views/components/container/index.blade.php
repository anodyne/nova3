@props([
    'height' => 'md',
    'width' => 'md',
    'size' => null,
])

<div
    data-slot="container"
    @class([
        match ($height) {
            'none' => 'py-0',
            '2xs' => 'py-1.5',
            'xs' => 'py-3',
            'sm' => 'py-4',
            default => 'py-6',
            'lg' => 'py-8',
            'xl' => 'py-12',
        },
        match ($width) {
            'none' => 'px-0',
            '2xs' => 'px-1.5',
            'xs' => 'px-3',
            'sm' => 'px-4',
            default => 'px-6',
            'lg' => 'px-8',
            'xl' => 'px-12',
        },
        $attributes->get('class'),
    ])
>
    {{ $slot }}
</div>
