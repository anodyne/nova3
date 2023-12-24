@props([
    'name',
    'size' => 'md',
    'class' => '',
])

@php
    $size = match ($size) {
        'xs' => 'size-4',
        'sm' => 'size-5',
        'md' => 'size-6',
        'lg' => 'size-7',
        'xl' => 'size-8',
        '2xl' => 'size-12',
        default => $size,
    };
@endphp

<span data-slot="icon" {{ $attributes->merge(['class' => 'nova-icon']) }}>
    {{ icon(name: $name, size: $size, class: $class) }}
</span>
