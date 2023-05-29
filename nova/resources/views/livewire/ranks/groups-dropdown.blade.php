<div
    x-data="{ open: false }"
    @rank-groups-dropdown-close.window="open = false"
    @keydown.window.escape="open = false"
    @click.away="open = false"
    class="relative inline-block text-left w-full leading-0"
>
    <input type="hidden" name="group_id" value="{{ $selectedId }}">

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
                {{ $selected?->name ?? 'Select a rank group' }}

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
                <div class="group flex items-center rounded-md bg-gray-100 dark:bg-gray-600 border-2 border-gray-100 dark:border-gray-600 text-gray-500 dark:text-gray-400 mb-4 px-2 py-2 space-x-3 focus-within:border-gray-300 dark:focus-within:border-gray-500 focus-within:bg-white dark:focus-within:bg-gray-700 focus-within:text-gray-700">
                    <x-icon name="search" size="sm" class="shrink-0 text-gray-500 group-focus-within:text-gray-600 dark:group-focus-within:text-gray-400"></x-icon>

                    <input wire:model.debounce.250ms="search" type="text" placeholder="Find a rank group..." class="flex w-full appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none dark:placeholder-gray-400">

                    @isset($search)
                        <x-button.text wire:click="$set('search', null)" color="gray">
                            <x-icon name="dismiss" size="sm"></x-icon>
                        </x-button.text>
                    @endisset
                </div>

                @forelse ($filteredGroups as $group)
                    <button wire:click="selectGroup({{ $group->id }})" type="button" class="group rounded-md flex items-center justify-between w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600/50 dark:hover:text-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                        <div class="flex items-center space-x-3">
                            <x-status :status="$group->status"></x-status>
                            <span>{{ $group->name }}</span>
                        </div>

                        @if ($selectedId === $group->id)
                            <span
                                x-description="Checkmark, only display for selected option."
                                x-state:on="Highlighted"
                                x-state:off="Not Highlighted"
                                :class="{ 'text-white': selected === {{ $group->id }}, 'text-primary-500': !(selected === {{ $group->id }}) }"
                                class="flex items-center text-primary-500"
                            >
                                <x-icon name="check" size="md"></x-icon>
                            </span>
                        @endif
                    </button>
                @empty
                    <div class="flex flex-col items-center pt-2 pb-6">
                        <div class="text-base text-gray-500 dark:text-gray-400">There is no rank group named</div>
                        <div class="text-base text-gray-900 dark:text-gray-100 font-medium mt-1 mb-6">&lsquo;{{ $search }}&rsquo;</div>

                        <x-button.outline wire:click="createAndSelectGroup" type="button" color="primary">
                            Create this group
                        </x-button.outline>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
