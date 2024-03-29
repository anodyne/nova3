@props([
    'label' => false,
    'value' => null,
])

<div class="space-y-2 px-4 sm:px-6">
    @if (filled($label))
        <p class="text-sm font-medium leading-6 text-gray-600 dark:text-gray-400">{{ $label }}</p>
    @endif

    <p class="flex items-baseline gap-x-2">
        <span class="text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
            @if ($value !== null)
                {{ number_format((int) $value) }}
            @else
                {{ $slot }}
            @endif
        </span>
    </p>
</div>
