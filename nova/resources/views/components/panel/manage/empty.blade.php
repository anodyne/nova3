@props([
    'icon' => null,
    'heading' => null,
    'description' => null,
])

<x-container class="space-y-2 border-t border-gray-950/5 text-center dark:border-white/5">
    @if (filled($icon))
        <x-icon :name="$icon" size="2xl" class="mx-auto text-gray-500"></x-icon>
    @endif

    @if (filled($heading))
        <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $heading }}</h3>
    @endif

    @if (filled($description))
        <x-text>{{ $description }}</x-text>
    @endif
</x-container>
