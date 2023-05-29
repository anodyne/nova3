<div
    x-data="{ open: false }"
    @characters-dropdown-close.window="open = false"
    @keydown.window.escape="open = false"
    @click.away="open = false"
    class="relative inline-block text-left w-full"
>
    <div>
        <span class="relative flex w-full rounded-md shadow-sm">
            <button
                @click="open = !open"
                type="button"
                @class([
                    'flex items-center justify-between cursor-default relative w-full rounded-md border border-gray-300 dark:border-gray-200/[15%] focus-within:ring-1 focus-within:ring-primary-400 focus-within:border-primary-400 dark:focus-within:border-primary-600 dark:focus-within:ring-primary-600 bg-white dark:bg-gray-700/50 py-2 px-3 text-left focus:outline-none dark:focus:bg-gray-800 transition leading-normal space-x-4',
                    'text-gray-900 dark:text-white' => $selected?->name,
                ])
                aria-haspopup="true"
                aria-expanded="true"
                :aria-expanded="open"
            >
                @if ($selected)
                    <div class="flex items-center space-x-3">
                        <x-status :status="$selected->status" />
                        <span class="ml-3">{{ $selected->name }}</span>
                    </div>
                @else
                    <span>Pick a character</span>
                @endif

                <svg class="ml-2 h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </span>
    </div>

    <div
        x-show="open"
        x-description="Dropdown panel, show/hide based on dropdown state."
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="origin-top-left absolute left-0 mt-2 w-full rounded-md shadow-lg"
        x-cloak
    >
        <div class="relative rounded-md bg-white ring-1 ring-black ring-opacity-5 max-h-60 overflow-auto z-10">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                <div class="p-2">
                    <div class="group flex items-center rounded-md bg-gray-100 border-2 border-gray-100 text-gray-600 px-2 py-2 space-x-3 focus-within:border-gray-300 focus-within:bg-white focus-within:text-gray-700">
                        <x-icon name="search" size="sm" class="shrink-0 text-gray-500 group-focus-within:text-gray-600"></x-icon>

                        <input wire:model.debounce.250ms="search" type="text" placeholder="Find a character..." class="flex w-full appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none">

                        @isset($search)
                            <x-button.text wire:click="$set('search', null)" color="gray">
                                <x-icon name="dismiss" size="sm"></x-icon>
                            </x-button.text>
                        @endisset
                    </div>
                </div>

                @forelse ($characters as $character)
                    <button wire:click="selectCharacter({{ $character->id }})" type="button" class="inline-flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center space-x-3">
                                <x-status :status="$character->status" />
                                <span>{{ $character->name }}</span>
                            </div>
                            <x-badge :color="$character->type->color()">
                                {{ $character->type->displayName() }}
                            </x-badge>
                        </div>
                    </button>
                @empty
                    <span class="block w-full text-left px-4 py-2 text-sm text-gray-700 focus:outline-none" role="menuitem">
                        No characters found
                    </span>
                @endforelse
            </div>
        </div>
    </div>
</div>
