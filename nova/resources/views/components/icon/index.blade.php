@props([
    'name',
    'size' => 'md',
    'class' => '',
])

@php
    $size = match ($size) {
        'xs' => 'h-4 w-4',
        'sm' => 'h-5 w-5',
        'md' => 'h-6 w-6',
        'lg' => 'h-7 w-7',
        'xl' => 'h-8 w-8',
        '2xl' => 'h-12 w-12',
        default => $size,
    };
@endphp

<span {{ $attributes->merge(['class' => 'nova-icon']) }}>
    {{ icon(name: $name, size: $size, class: $class) }}
</span>
