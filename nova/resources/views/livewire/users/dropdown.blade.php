<div
    x-data="{ open: false }"
    @users-dropdown-close.window="open = false"
    @keydown.window.escape="open = false"
    @click.away="open = false"
    class="relative inline-block text-left w-full leading-0"
>
    <div>
        <span class="relative flex w-full rounded-md shadow-sm">
            <button
                @click="open = !open"
                type="button"
                @class([
                    'flex items-center justify-between cursor-default relative w-full rounded-md ring-1 ring-inset ring-gray-300 dark:ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-primary-600 dark:focus-within:ring-primary-500 bg-white dark:bg-opacity-5 py-2.5 px-3 text-left focus:outline-none transition leading-normal space-x-4',
                    'text-gray-900 dark:text-white' => $selected?->name,
                ])
                aria-haspopup="true"
                aria-expanded="true"
                :aria-expanded="open"
            >
                @if ($selected)
                    <div class="flex items-center space-x-2">
                        <x-status :status="$selected->status" />
                        <span>{{ $selected->name }}</span>
                    </div>
                @else
                    <span>Pick a user</span>
                @endif

                <x-icon.chevron-down class="h-5 w-5 text-gray-400 dark:text-gray-500" />
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
        class="absolute mt-2 rounded-lg shadow-lg origin-top-left left-0 w-full"
        x-cloak
    >
        <div class="relative rounded-lg bg-white dark:bg-gray-700 ring-1 ring-gray-900/5 dark:ring-gray-700 z-10 divide-y divide-gray-100 dark:divide-gray-700 dark:highlight-white/10 max-h-60 overflow-auto">
            <div class="p-1.5" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                <div class="mb-2">
                    <div class="group flex items-center rounded-md bg-gray-100 dark:bg-gray-600 border-2 border-gray-100 dark:border-gray-600 text-gray-500 dark:text-gray-400 mb-4 px-2 py-2 space-x-3 focus-within:border-gray-300 dark:focus-within:border-gray-500 focus-within:bg-white dark:focus-within:bg-gray-700 focus-within:text-gray-700">
                        <x-icon name="search" size="sm" class="shrink-0 text-gray-500 group-focus-within:text-gray-600 dark:group-focus-within:text-gray-400"></x-icon>

                        <input wire:model.debounce.250ms="search" type="text" placeholder="Find a user..." class="flex w-full appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none dark:placeholder-gray-400">

                        @isset($search)
                            <x-button.text wire:click="$set('search', null)" color="gray">
                                <x-icon name="dismiss" size="sm"></x-icon>
                            </x-button.text>
                        @endisset
                    </div>
                </div>

                @forelse ($filteredUsers as $user)
                    <button wire:click="selectUser({{ $user->id }})" type="button" class="group rounded-md flex items-center justify-between w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600/50 dark:hover:text-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                        <div class="flex items-center space-x-2">
                            <x-status :status="$user->status" />
                            <span>{{ $user->name }}</span>
                        </div>
                    </button>
                @empty
                    <span class="block px-4 py-3 text-sm text-gray-600 dark:text-gray-400" role="menuitem">
                        No users found
                    </span>
                @endforelse
            </div>
        </div>
    </div>
</div>
