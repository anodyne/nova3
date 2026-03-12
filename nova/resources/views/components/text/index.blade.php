@props([
    'color' => null,
    'size' => 'sm',
])

@php
    if ($color !== null) {
        $color = settings('appearance')->getColorFromSemanticColor($color);
    }

    $textSize = match ($size) {
        'xl' => 'text-lg',
        'lg' => 'text-base',
        default => 'text-sm',
    };

    $leading = match ($size) {
        'xl' => 'leading-8',
        'lg' => 'leading-7',
        default => 'leading-6',
    };
@endphp

<flux:text :$color {{ $attributes->class([$leading, $textSize]) }}>
    {{ $slot }}
</flux:text>
