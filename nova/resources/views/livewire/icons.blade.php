<div
    x-data="{ open: false }"
    @keydown.window.escape="open = false"
    @click.away="open = false"
    @icons-dropdown-close.window="open = false"
    class="relative inline-block text-left w-full leading-0"
>
    <input type="hidden" name="icon" value="{{ $selected }}">

    <div>
        <span class="relative flex w-full rounded-md shadow-sm">
            <button
                @click="open = !open"
                type="button"
                @class([
                    'flex items-center justify-between cursor-default relative w-full rounded-md ring-1 ring-inset ring-gray-300 dark:ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-primary-600 dark:focus-within:ring-primary-500 bg-white dark:bg-opacity-5 py-2.5 px-3 text-left focus:outline-none transition leading-normal space-x-4',
                    'text-gray-900 dark:text-white' => $selected,
                ])
                aria-haspopup="true"
                aria-expanded="true"
                :aria-expanded="open"
            >
                <span class="flex items-center space-x-2 truncate">
                    @isset($selected)
                        <x-icon :name="$selected" size="md" class="shrink-0"></x-icon>
                        <span>{{ $selected }}</span>
                    @else
                        Select an icon
                    @endisset
                </span>

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

                        <input wire:model.debounce.250ms="search" type="text" placeholder="Find an icon" class="flex w-full appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none dark:placeholder-gray-400">

                        @isset($search)
                            <x-button.text wire:click="$set('search', null)" color="gray">
                                <x-icon name="dismiss" size="sm"></x-icon>
                            </x-button.text>
                        @endisset
                    </div>
                </div>

                @if (count($icons) > 0)
                    <div class="flex flex-wrap">
                        <div class="flex items-center justify-center">
                            <button type="button" wire:click="selectIcon('')" class="group rounded-md flex flex-col items-center text-xs font-medium leading-tight w-full px-4 py-2 transition text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600/50 dark:hover:text-gray-100 hover:text-gray-900 focus:outline-none">
                                <span class="h-8 w-8 shrink-0">No<br>icon</span>
                            </button>
                        </div>

                        @foreach ($icons as $icon => $value)
                            <div class="flex items-center justify-center">
                                <button wire:click="selectIcon('{{ $icon }}')" type="button" class="group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600/50 dark:hover:text-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                                    <x-icon :name="$icon" size="xl" class="shrink-0"></x-icon>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-4">
                        <div class="text-center leading-normal">
                            <div class="text-gray-500 dark:text-gray-400">No icons found with the name</div>
                            <div class="text-gray-900 dark:text-white font-medium mt-1">&lsquo;{{ $search }}&rsquo;</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
