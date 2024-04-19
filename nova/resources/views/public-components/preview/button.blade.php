@props([
    'primary' => false,
    'bgColor' => null,
    'textColor' => null,
])

<div
    style="--bgColor:{{ $bgColor ?? null }};--textColor:{{ $textColor ?? '#ffffff' }}"
    @class([
        'rounded-lg px-3.5 py-2.5 text-center text-sm/6 font-semibold',
        'bg-[--bgColor] text-[--textColor] shadow-sm' => $primary,
        'text-gray-900 dark:text-white' => ! $primary,
    ])
    {{ $attributes }}
>
    {{ $slot }}
</div>
