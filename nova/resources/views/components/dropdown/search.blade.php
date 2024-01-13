@props([
    'search',
    'placeholder',
])

<div
    class="group relative flex w-full items-center gap-x-2 bg-gray-950/[.02] px-3 py-3 sm:py-2 dark:bg-white/[.02]"
    data-slot="search"
>
    <div
        class="shrink-0 text-gray-400 group-focus-within:text-gray-600 dark:text-gray-600 dark:group-focus-within:text-gray-400"
    >
        <x-icon name="search" size="sm"></x-icon>
    </div>

    <input
        type="text"
        wire:model.live.debounce.500ms="search"
        class="w-full appearance-none border-none bg-transparent p-0 placeholder-gray-500 focus:outline-none focus:ring-0 sm:text-sm/6"
        placeholder="{{ $placeholder }}"
    />

    @if (filled($search))
        <x-button tag="button" color="neutral" wire:click="$set('search', '')" text>
            <x-icon name="x" size="sm"></x-icon>
        </x-button>
    @endif
</div>
