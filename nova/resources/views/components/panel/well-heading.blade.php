@props([
    'heading' => null,
    'description' => null,
    'controls' => null,
])

<x-spacing width="md" height="sm">
    <div class="flex items-center justify-between">
        <div class="space-y-1.5">
            @if (filled($heading))
                <h3 class="text-base/6 font-semibold text-gray-950 dark:text-white">{{ $heading }}</h3>
            @endif

            @if (filled($description))
                <x-text>{{ $description }}</x-text>
            @endif
        </div>

        @if ($controls?->isNotEmpty())
            {{ $controls }}
        @endif
    </div>
</x-spacing>
