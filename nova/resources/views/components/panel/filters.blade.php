@props(['title' => 'Filters'])

<x-content-box class="border-t border-gray-200 dark:border-gray-700" {{ $attributes }}>
    <div class="mb-4 flex items-center space-x-4">
        @if ($title)
            <h2 class="text-lg font-semibold">{{ $title }}</h2>

            <div class="h-5 w-px border-l border-gray-200 dark:border-gray-700"></div>
        @endif

        <x-button.text tag="button" color="gray" wire:click="clearAll">Clear all</x-button.text>
    </div>

    <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
        {{ $slot }}
    </div>
</x-content-box>
