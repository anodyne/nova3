@props([
    'name',
    'size' => '',
])

@php
    $attributes = $attributes
        ->merge(['data-slot' => 'icon'])
        ->class([
            'nova-icon',
            match ($size) {
                'xs' => 'size-4',
                'sm' => 'size-5',
                'md' => 'size-6',
                'lg' => 'size-7',
                'xl' => 'size-8',
                '2xl' => 'size-12',
                default => $size,
            },
        ]);
@endphp

{{
    svg(
        $name->value,
        $attributes->first('class'),
        $attributes->except('class')->all()
    )
}}
