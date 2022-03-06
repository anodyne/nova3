@props(['title' => 'Filters'])

<x-content-box class="border-t border-gray-6" {{ $attributes }}>
    <div class="flex items-center space-x-4 mb-4">
        @if ($title)
            <h2 class="text-lg font-semibold text-gray-11">{{ $title }}</h2>

            <div class="w-px h-5 border-l border-gray-6"></div>
        @endif

        <x-button size="none" color="gray-text" wire:click="clearAll">Clear all</x-button>
    </div>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">
        {{ $slot }}
    </div>
</x-content-box>