@props([
    'icon' => false,
    'heading' => false,
])

@php($iconSize = $attributes->pluck('icon:size') ?? 'lg')

<flux:callout :inline="! $heading" {{ $attributes->merge(['color' => 'gray']) }}>
    @if ($icon)
        <x-slot name="icon" class="text-(--callout-icon)">
            <x-icon :name="$icon" :size="$iconSize" />
        </x-slot>
    @endif

    @if ($heading)
        <div
            @class([
                '[--callout-header:color-mix(in_oklab,var(--callout-heading),black_20%)]',
                'dark:[--callout-header:color-mix(in_oklab,var(--callout-heading),white_20%)]',
                'flex items-center gap-2 text-base font-semibold text-(--callout-header)',
            ])
        >
            {{ $heading }}
        </div>
    @endif

    <flux:callout.text @class([
        'leading-6',
        'font-medium' => ! $heading,
    ])>
        {{ $slot }}
    </flux:callout.text>
</flux:callout>
