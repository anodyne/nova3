@props([
    'label' => null,
    'value' => null,
    'icon' => null,
    'variant' => null,
])

<div
    {{
        $attributes->class([
            'flex items-center gap-1 text-gray-500 dark:text-gray-400',
            'has-[[data-slot=icon]]:gap-1.5 [&>[data-slot=icon]]:size-5 [&>[data-slot=icon]]:shrink-0',
        ])
    }}
>
    @if (filled($icon))
        <x-icon :name="$icon" />
    @else
        <span>{{ $label }}</span>
    @endif

    <span
        @class([
            'flex items-center font-semibold',
            match ($variant) {
                'subtle' => 'text-gray-500 dark:text-gray-400',
                default => 'text-gray-900 dark:text-white',
            },
        ])
    >
        @if (filled($value))
            {{ $value }}
        @else
            {{ $slot }}
        @endif
    </span>
</div>
