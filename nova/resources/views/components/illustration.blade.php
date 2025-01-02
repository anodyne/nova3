@props([
    'name',
    'size' => '',
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

{{ icon(name: $name, size: $size, class: Arr::toCssClasses([$class]), attributes: ['data-slot' => 'illustration']) }}
