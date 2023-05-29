@props([
    'icon',
    'title',
    'message' => false,
    'link',
    'label',
    'linkAccess' => false,
])

<x-panel as="extra-light-well">
    <x-content-box class="text-center">
        <x-icon :name="$icon" size="h-12 w-12" class="mx-auto text-gray-400 dark:text-gray-500"></x-icon>

        <h3 class="mt-2 text-base font-medium text-gray-600 dark:text-gray-400">{{ $title }}</h3>

        @if ($message)
            <p class="mt-1 text-sm text-gray-500">{{ $message }}</p>
        @endif

        @if ($linkAccess)
            <x-button.text :href="$link" size="xs" class="space-x-3 mt-4">
                <span>{{ $label }}</span>
            </x-button.text>
        @endif
    </x-content-box>
</x-panel>