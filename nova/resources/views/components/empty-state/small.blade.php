@props([
    'icon',
    'title',
    'message' => false,
    'link',
    'label',
    'linkAccess' => false,
])

<x-spacing size="md" class="text-center">
    <x-icon :name="$icon" size="h-12 w-12" class="mx-auto text-gray-400 dark:text-gray-500"></x-icon>

    <h3 class="mt-4 text-base/7 font-medium text-gray-700 dark:text-gray-300">{{ $title }}</h3>

    @if ($message)
        <x-text class="mx-auto mt-2 max-w-lg">{{ $message }}</x-text>
    @endif

    @if ($linkAccess)
        <x-button :href="$link" size="md" class="mt-4 space-x-3" plain>
            {!! $label !!}
        </x-button>
    @endif
</x-spacing>
