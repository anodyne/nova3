@props([
    'type' => 'button',
    'leading' => false,
    'trailing' => false,
    'size' => 'base',
    'outline' => false,
    'plain' => false,
    'text' => false,
    'color' => 'neutral',
])

@use('Illuminate\Support\Arr')

@php
    $tag = $attributes->has('href') ? 'a' : 'button';

    $variant = $outline ? 'outline' : ($plain ? 'plain' : ($text ? 'text' : 'solid'));

    $size = $text ? 'none' : $size;

    $color = ($color === 'primary' && settings('appearance.panda')) ? 'panda' : $color;
@endphp

<{{ $tag }}
    {{
        $attributes->merge([
            'type' => ($tag === 'button') ? $type : null,
        ])->class([
            'nv-btn-primary w-full rounded-lg px-3.5 py-2.5 text-center text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 lg:w-auto',
            // 'nv-btn-primary-light bg-primary-600 text-white hover:bg-primary-500 focus-visible:outline-primary-600' => ! $dark,
            // 'nv-btn-primary-dark bg-primary-500 text-white hover:bg-primary-400 focus-visible:outline-primary-400' => $dark,
        ])
    }}
>
    {{ $slot }}
</{{ $tag }}>
