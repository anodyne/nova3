<div x-data="{ open: false }" x-on:characters-dropdown-close.window="open = false" x-on:keydown.window.escape="open = false" x-on:click.away="open = false" class="relative inline-block w-full text-left">
    <div>
        <span class="relative flex w-full rounded-md shadow-sm">
            <button x-on:click="open = !open" type="button" @class([
                'relative flex w-full cursor-default items-center justify-between space-x-4 rounded-md border border-gray-300 bg-white px-3 py-2 text-left leading-normal transition focus-within:border-primary-400 focus-within:ring-1 focus-within:ring-primary-400 focus:outline-none dark:border-gray-200/[15%] dark:bg-gray-700/50 dark:focus-within:border-primary-600 dark:focus-within:ring-primary-600 dark:focus:bg-gray-800',
                'text-gray-900 dark:text-white' => $selected?->name,
            ]) aria-haspopup="true" aria-expanded="true" :aria-expanded="open">
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

    <div x-show="open" x-description="Dropdown panel, show/hide based on dropdown state." x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 mt-2 w-full origin-top-left rounded-md shadow-lg" x-cloak>
        <div class="relative z-10 max-h-60 overflow-auto rounded-md bg-white ring-1 ring-black ring-opacity-5">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                <div class="p-2">
                    <div class="group flex items-center space-x-3 rounded-md border-2 border-gray-100 bg-gray-100 px-2 py-2 text-gray-600 focus-within:border-gray-300 focus-within:bg-white focus-within:text-gray-700">
                        <x-icon name="search" size="sm" class="shrink-0 text-gray-500 group-focus-within:text-gray-600"></x-icon>

                        <input wire:model.debounce.250ms="search" type="text" placeholder="Find a character..." class="flex w-full appearance-none border-none bg-transparent p-0 focus:outline-none focus:ring-0" />

                        @isset($search)
                            <x-button.text wire:click="$set('search', null)" color="gray">
                                <x-icon name="dismiss" size="sm"></x-icon>
                            </x-button.text>
                        @endisset
                    </div>
                </div>

                @forelse ($characters as $character)
                    <button wire:click="selectCharacter({{ $character->id }})" type="button" class="inline-flex w-full items-center px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                        <div class="flex w-full items-center justify-between">
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
                    <span class="block w-full px-4 py-2 text-left text-sm text-gray-700 focus:outline-none" role="menuitem">No characters found</span>
                @endforelse
            </div>
        </div>
    </div>
</div>
