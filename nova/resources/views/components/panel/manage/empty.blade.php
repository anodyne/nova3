@props([
    'icon' => null,
    'heading' => null,
    'description' => null,
])

<x-spacing size="md" class="space-y-2 text-center">
    @if (filled($icon))
        <x-icon :name="$icon" size="2xl" class="mx-auto text-gray-500"></x-icon>
    @endif

    @if (filled($heading))
        <h3 class="text-sm/6 font-medium text-gray-950 dark:text-white">{{ $heading }}</h3>
    @endif

    @if (filled($description))
        <x-text>{{ $description }}</x-text>
    @endif
</x-spacing>
