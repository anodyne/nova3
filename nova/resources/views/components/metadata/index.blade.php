@props([
    'label' => null,
    'value' => null,
    'icon' => null,
])

<div
    {{
        $attributes->class([
            'flex items-center gap-x-1 text-gray-500',
            'has-[[data-slot=icon]]:gap-x-1.5 [&>[data-slot=icon]]:size-5 [&>[data-slot=icon]]:shrink-0',
        ])
    }}
>
    @if (filled($icon))
        <x-icon :name="$icon"></x-icon>
    @else
        <span>{{ $label }}</span>
    @endif

    <span class="font-semibold text-gray-900 dark:text-white">
        @if (filled($value))
            {{ $value }}
        @else
            {{ $slot }}
        @endif
    </span>
</div>
