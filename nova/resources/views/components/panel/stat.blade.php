@props([
    'label' => false,
    'value' => null,
])

<div {{ $attributes->class(['space-y-2']) }}>
    @if (filled($label))
        <p class="text-sm/6 font-medium text-gray-500 dark:text-gray-400">{{ $label }}</p>
    @endif

    <p class="flex items-baseline gap-2">
        <span class="text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
            @if ($value !== null)
                {{ number_format((int) $value) }}
            @else
                {{ $slot }}
            @endif
        </span>
    </p>
</div>
