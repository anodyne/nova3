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

        <h3 class="mt-4 text-base/7 font-medium text-gray-700 dark:text-gray-300">{{ $title }}</h3>

        @if ($message)
            <p class="mx-auto mt-2 max-w-lg text-sm/6 text-gray-600 dark:text-gray-400">{{ $message }}</p>
        @endif

        @if ($linkAccess)
            <x-button.text :href="$link" size="md" class="mt-4 space-x-3">
                <span>{{ $label }}</span>
            </x-button.text>
        @endif
    </x-content-box>
</x-panel>
