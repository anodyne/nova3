<div x-data="{ open: false }" x-on:users-dropdown-close.window="open = false" x-on:keydown.window.escape="open = false" x-on:click.away="open = false" class="relative inline-block w-full text-left leading-0">
    <div>
        <span class="relative flex w-full rounded-md shadow-sm">
            <button x-on:click="open = !open" type="button" @class([
                'relative flex w-full cursor-default items-center justify-between space-x-4 rounded-md bg-white px-3 py-2.5 text-left leading-normal ring-1 ring-inset ring-gray-300 transition focus-within:ring-2 focus-within:ring-inset focus-within:ring-primary-600 focus:outline-none dark:bg-opacity-5 dark:ring-white/10 dark:focus-within:ring-primary-500',
                'text-gray-900 dark:text-white' => $selected?->name,
            ]) aria-haspopup="true" aria-expanded="true" :aria-expanded="open">
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

    <div x-show="open" x-description="Dropdown panel, show/hide based on dropdown state." x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 mt-2 w-full origin-top-left rounded-lg shadow-lg" x-cloak>
        <div class="relative z-10 max-h-60 divide-y divide-gray-100 overflow-auto rounded-lg bg-white ring-1 ring-gray-900/5 dark:divide-gray-700 dark:bg-gray-700 dark:ring-gray-700 dark:highlight-white/10">
            <div class="p-1.5" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                <div class="mb-2">
                    <div class="group mb-4 flex items-center space-x-3 rounded-md border-2 border-gray-100 bg-gray-100 px-2 py-2 text-gray-500 focus-within:border-gray-300 focus-within:bg-white focus-within:text-gray-700 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-400 dark:focus-within:border-gray-500 dark:focus-within:bg-gray-700">
                        <x-icon name="search" size="sm" class="shrink-0 text-gray-500 group-focus-within:text-gray-600 dark:group-focus-within:text-gray-400"></x-icon>

                        <input wire:model.debounce.250ms="search" type="text" placeholder="Find a user..." class="flex w-full appearance-none border-none bg-transparent p-0 focus:outline-none focus:ring-0 dark:placeholder-gray-400" />

                        @isset($search)
                            <x-button.text wire:click="$set('search', null)" color="gray">
                                <x-icon name="dismiss" size="sm"></x-icon>
                            </x-button.text>
                        @endisset
                    </div>
                </div>

                @forelse ($filteredUsers as $user)
                    <button wire:click="selectUser({{ $user->id }})" type="button" class="group flex w-full items-center justify-between rounded-md px-4 py-2 text-base font-medium text-gray-500 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-600/50 dark:hover:text-gray-100 md:text-sm" role="menuitem">
                        <div class="flex items-center space-x-2">
                            <x-status :status="$user->status" />
                            <span>{{ $user->name }}</span>
                        </div>
                    </button>
                @empty
                    <span class="block px-4 py-3 text-sm text-gray-600 dark:text-gray-400" role="menuitem">No users found</span>
                @endforelse
            </div>
        </div>
    </div>
</div>
