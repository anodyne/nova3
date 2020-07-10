<div
    x-data="{ open: false }"
    x-on:positions-dropdown-close.window="open = false"
    x-on:keydown.window.escape="open = false"
    x-on:click.away="open = false"
    class="relative inline-block text-left w-full"
>
    <div>
        <span class="rounded-md shadow-sm">
            <button
                x-on:click="open = !open"
                type="button"
                class="flex items-center justify-between cursor-default relative w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-left focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition ease-in-out duration-150 | sm:text-sm sm:leading-5"
                aria-haspopup="true"
                aria-expanded="true"
                x-bind:aria-expanded="open"
            >
                {{ optional($selected)->name ?? 'Pick a user'}}

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
        <div class="relative rounded-md bg-white shadow-xs max-h-60 overflow-auto z-10">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                <div class="p-2">
                    <div class="flex items-center rounded bg-gray-100 border-2 border-gray-100 text-gray-600 px-2 py-2 focus-within:border-gray-200 focus-within:bg-white focus-within:text-gray-700">
                        <div class="flex-shrink-0 mr-3">
                            @icon('search', 'h-5 w-5')
                        </div>
                        <input wire:model.debounce.250ms="query" type="text" placeholder="Find a user..." class="block w-full appearance-none bg-transparent focus:outline-none">
                    </div>
                </div>

                @forelse ($users as $user)
                    <button wire:click="selectUser({{ $user->id }})" type="button" class="inline-flex items-center space-x-3 w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                        <span aria-label="{{ $user->status->displayName() }}" class="bg-{{ $user->status->color() }}-400 flex-shrink-0 inline-block h-2 w-2 rounded-full"></span>
                        <span>{{ $user->name }}</span>
                    </button>
                @empty
                    <span class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 focus:outline-none" role="menuitem">
                        No users found
                    </span>
                @endforelse
            </div>
        </div>
    </div>
</div>
