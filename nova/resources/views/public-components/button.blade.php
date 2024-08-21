@props([
    'type' => 'button',
    'primary' => false,
    'bgColor' => null,
    'textColor' => null,
])

@php
    $tag = $attributes->has('href') ? 'a' : 'button';

    if ($primary) {
        $bgColor ??= theme('settings')->accentColor();
        $textColor ??= theme('settings')->textAccentColor();
    }
@endphp

<{{ $tag }}
    {{ $attributes->merge(['type' => ($tag === 'button') ? $type : null]) }}
    @class([
        'nv-btn-primary' => $primary,
        'nv-btn-secondary' => ! $primary,
        'relative rounded-lg px-3.5 py-2.5 text-center text-sm/6 font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2',
        'bg-[--nv-page-btn-bg-color] text-[--nv-page-btn-text-color] shadow-sm' => $primary,
        'before:z-1 before:absolute before:inset-0 before:rounded-[calc(theme(borderRadius.lg)-1px)] before:bg-white before:bg-opacity-0 before:hover:bg-opacity-10' => $primary,
        'text-gray-900 hover:bg-black/5 dark:text-white dark:hover:bg-white/5' => ! $primary,
        $attributes->get('class') => $attributes->has('class'),
    ])
    @style([
        "--nv-page-btn-bg-color:{$bgColor}" => $primary,
        "--nv-page-btn-text-color:{$textColor}" => $primary,
    ])
>
    {{ $slot }}
</{{ $tag }}>
