@props([
    'search',
    'placeholder' => 'Search...',
])

<x-spacing size="2xs">
    <div class="relative">
        <div
            class="group relative flex w-full items-center gap-x-2 rounded-lg bg-gray-950/[.02] px-4 py-2 ring-1 ring-inset ring-gray-950/5 dark:bg-white/[.04] dark:ring-white/5"
        >
            <div
                class="shrink-0 text-gray-400 group-focus-within:text-gray-600 dark:text-gray-600 dark:group-focus-within:text-gray-400"
            >
                <x-icon name="search" size="sm"></x-icon>
            </div>

            <input
                type="text"
                wire:model.live.debounce.500ms="search"
                class="w-full appearance-none border-none bg-transparent p-0 text-sm/6 placeholder-gray-500 focus:outline-none focus:ring-0"
                placeholder="{{ $placeholder }}"
            />

            @if ($search)
                <x-button tag="button" color="neutral" wire:click="$set('search', '')" text class="leading-none">
                    <x-icon name="x" size="sm"></x-icon>
                </x-button>
            @endif
        </div>

        @if (filled($search))
            <div
                class="absolute top-auto isolate z-10 mt-2 max-h-60 w-full divide-y divide-gray-950/5 overflow-y-scroll rounded-lg bg-white shadow-lg ring-1 ring-gray-950/5 dark:divide-white/5 dark:bg-gray-800"
            >
                {{ $slot }}
            </div>
        @endif
    </div>
</x-spacing>
