@props([
    'icon' => null,
    'iconSize' => 'md',
    'title' => null,
    'description' => null,
])

<x-panel variant="well" color="info">
    <x-panel.header
        :title="$title"
        :icon="$icon"
        :icon-size="$iconSize"
        :description="$description"
    ></x-panel.header>

    {{ $slot }}
</x-panel>
