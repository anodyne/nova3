<div
    x-data="{ open: false }"
    @users-dropdown-close.window="open = false"
    @keydown.window.escape="open = false"
    @click.away="open = false"
    class="relative inline-block text-left w-full"
>
    <div>
        <span class="relative flex w-full rounded-md shadow-sm">
            <button
                @click="open = !open"
                type="button"
                class="flex items-center justify-between cursor-default relative w-full rounded-md border border-gray-6 bg-gray-1 px-3 py-2 text-left focus:outline-none focus:ring focus:border-blue-7 transition ease-in-out duration-150"
                aria-haspopup="true"
                aria-expanded="true"
                :aria-expanded="open"
            >
                @if ($selected)
                    <div class="flex items-center space-x-3">
                        <x-status :status="$selected->status" />
                        <span>{{ $selected->name }}</span>
                    </div>
                @else
                    <span>Pick a user</span>
                @endif

                <svg class="ml-2 h-5 w-5 text-gray-9" viewBox="0 0 20 20" fill="currentColor">
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
        <div class="relative rounded-lg bg-gray-1 ring-1 ring-gray-12 ring-opacity-5 max-h-60 overflow-auto z-10">
            <div class="p-1.5" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                <div class="mb-2">
                    <div class="group flex items-center rounded-md bg-gray-3 border-2 border-gray-3 text-gray-9 px-2 py-2 space-x-3 focus-within:border-gray-6 focus-within:bg-gray-1 focus-within:text-gray-11">
                        @icon('search', 'flex-shrink-0 h-5 w-5 text-gray-9 group-focus-within:text-gray-11')

                        <input wire:model.debounce.250ms="search" type="text" placeholder="Find a user..." class="flex w-full appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none">

                        @isset($search)
                            <x-button wire:click="$set('search', null)" color="gray-text" size="none">
                                @icon('close')
                            </x-button>
                        @endisset
                    </div>
                </div>

                @forelse ($users as $user)
                    <button wire:click="selectUser({{ $user->id }})" type="button" class="inline-flex items-center space-x-3 w-full text-left px-4 py-2 text-sm rounded-md text-gray-11 transition ease-in-out duration-150 hover:bg-gray-3 hover:text-gray-12 focus:outline-none" role="menuitem">
                        <x-status :status="$user->status" />
                        <span>{{ $user->name }}</span>
                    </button>
                @empty
                    <span class="block w-full text-left px-4 py-2 text-sm text-gray-11 focus:outline-none" role="menuitem">
                        No users found
                    </span>
                @endforelse
            </div>
        </div>
    </div>
</div>
