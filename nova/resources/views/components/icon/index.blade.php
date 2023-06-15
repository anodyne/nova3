@props([
    'name',
    'size' => 'md',
    'class' => '',
])

@php
    $size = match ($size) {
        'xs' => 'h-5 w-5 md:h-4 md:w-4',
        'sm' => 'h-6 w-6 md:h-5 md:w-5',
        'md' => 'h-7 w-7 md:h-6 md:w-6',
        'lg' => 'h-8 w-8 md:h-7 md:w-7',
        'xl' => 'h-9 w-9 md:h-8 md:w-8',
        '2xl' => 'h-14 w-14 md:h-12 md:w-12',
        default => $size,
    };
@endphp

<span {{ $attributes->merge(['class' => 'nova-icon']) }}>
    {{ icon(name: $name, size: $size, class: $class) }}
</span>
