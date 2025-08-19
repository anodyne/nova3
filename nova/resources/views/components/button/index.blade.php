@props([
    'leading' => false,
    'trailing' => false,
    'size' => 'base',
    'outline' => false,
    'plain' => false,
    'text' => false,
    'color' => 'neutral',
    'variant' => null,
])

@php
    $variant ??= match (true) {
        $plain => 'ghost',
        $text => 'subtle',
        $color === 'primary' => 'primary',
        $color === 'danger' => 'danger',
        default => 'outline',
    };

    $size = match ($size) {
        'xs' => 'xs',
        'sm' => 'sm',
        'lg' => 'lg',
        default => 'base',
    };

    $scaling = 'active:scale-98 active:transition active:duration-150';

    $container = 'flex items-center gap-2';
@endphp

<flux:button :$variant :$size {{ $attributes->merge(['data-slot' => 'button'])->class([$scaling, $container]) }}>
    {{ $slot }}
</flux:button>
