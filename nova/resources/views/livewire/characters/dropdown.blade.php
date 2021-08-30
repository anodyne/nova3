<div
    x-data="{ open: false }"
    x-on:characters-dropdown-close.window="open = false"
    x-on:keydown.window.escape="open = false"
    x-on:click.away="open = false"
    class="relative inline-block text-left w-full"
>
    <div>
        <span class="relative flex w-full rounded-md shadow-sm">
            <button
                x-on:click="open = !open"
                type="button"
                class="flex items-center justify-between cursor-default relative w-full rounded-md border border-gray-200 bg-gray-1 px-3 py-2 text-left focus:outline-none focus:ring focus:border-blue-7 transition ease-in-out duration-150"
                aria-haspopup="true"
                aria-expanded="true"
                x-bind:aria-expanded="open"
            >
                @if ($selected)
                    <div class="flex items-center space-x-3">
                        <x-status :status="$selected->status" />
                        <span class="ml-3">{{ $selected->name }}</span>
                    </div>
                @else
                    <span>Pick a character</span>
                @endif

                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </span>
    </div>

    <div
        x-show="open"
        x-description="Dropdown panel, show/hide based on dropdown state."
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-left absolute left-0 mt-2 w-full rounded-md shadow-lg"
        x-cloak
    >
        <div class="relative rounded-md bg-gray-1 ring-1 ring-black ring-opacity-5 max-h-60 overflow-auto z-10">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                <div class="p-2">
                    <div class="group flex items-center rounded-md bg-gray-100 border-2 border-gray-100 text-gray-600 px-2 py-2 space-x-3 focus-within:border-gray-200 focus-within:bg-gray-1 focus-within:text-gray-700">
                        @icon('search', 'h-5 w-5 flex-shrink-0 text-gray-400 group-focus-within:text-gray-600')

                        <input wire:model.debounce.250ms="search" type="text" placeholder="Find a character..." class="flex w-full appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none">

                        @isset($search)
                            <x-button wire:click="$set('search', null)" color="gray-text" size="none">
                                @icon('close-alt')
                            </x-button>
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
                            <x-badge :color="$character->type->color()" size="xs">
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
