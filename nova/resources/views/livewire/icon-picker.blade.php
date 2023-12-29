<div
    x-data="{ open: false }"
    x-on:keydown.window.escape="open = false"
    x-on:click.away="open = false"
    x-on:icons-dropdown-close.window="open = false"
    class="relative inline-block w-full text-left leading-0"
>
    <input type="hidden" name="icon" value="{{ $selected }}" />

    <div>
        <span class="relative flex w-full rounded-md shadow-sm">
            <button
                x-on:click="open = !open"
                type="button"
                @class([
                    'relative flex w-full cursor-default items-center justify-between space-x-4 rounded-md bg-white px-3 py-2.5 text-left leading-normal ring-1 ring-inset ring-gray-300 transition focus-within:ring-2 focus-within:ring-inset focus-within:ring-primary-600 focus:outline-none dark:bg-opacity-5 dark:ring-white/10 dark:focus-within:ring-primary-500',
                    'text-gray-900 dark:text-white' => filled($selected),
                ])
                aria-haspopup="true"
                aria-expanded="true"
                x-bind:aria-expanded="open"
            >
                <span class="flex items-center space-x-2 truncate">
                    @if (filled($selected))
                        <x-icon :name="$selected" size="md" class="shrink-0"></x-icon>
                        <span>{{ $selected }}</span>
                    @else
                        Select an icon
                    @endif
                </span>

                <x-icon.chevron-down class="size-5 text-gray-400 dark:text-gray-500" />
            </button>
        </span>
    </div>

    <div
        x-show="open"
        x-description="Dropdown panel, show/hide based on dropdown state."
        x-transition:enter="transition duration-100 ease-out"
        x-transition:enter-start="scale-95 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transition duration-75 ease-in"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-95 opacity-0"
        class="absolute left-0 mt-2 w-full origin-top-left rounded-lg shadow-lg"
        x-cloak
    >
        <div
            class="relative z-10 max-h-60 divide-y divide-gray-100 overflow-auto rounded-lg bg-white ring-1 ring-gray-950/5 dark:divide-gray-700 dark:bg-gray-700 dark:ring-gray-700 dark:highlight-white/10"
        >
            <div class="p-1.5" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                <div class="mb-2">
                    <div
                        class="group mb-4 flex items-center space-x-3 rounded-md border-2 border-gray-100 bg-gray-100 px-2 py-2 text-gray-500 focus-within:border-gray-300 focus-within:bg-white focus-within:text-gray-700 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-400 dark:focus-within:border-gray-500 dark:focus-within:bg-gray-700"
                    >
                        <x-icon
                            name="search"
                            size="sm"
                            class="shrink-0 text-gray-500 group-focus-within:text-gray-600 dark:group-focus-within:text-gray-400"
                        ></x-icon>

                        <input
                            wire:model.live.debounce.250ms="search"
                            type="text"
                            placeholder="Find an icon"
                            class="flex w-full appearance-none border-none bg-transparent p-0 focus:outline-none focus:ring-0 dark:placeholder-gray-400"
                        />

                        @if (filled($search))
                            <x-button wire:click="$set('search', '')" color="neutral" text>
                                <x-icon name="x" size="sm"></x-icon>
                            </x-button>
                        @endif
                    </div>
                </div>

                @if (count($icons) > 0)
                    <div class="flex flex-wrap">
                        <div class="flex items-center justify-center">
                            <button
                                type="button"
                                wire:click="selectIcon('')"
                                class="group flex w-full flex-col items-center rounded-md px-4 py-2 text-xs font-medium leading-tight text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-600/50 dark:hover:text-gray-100"
                            >
                                <span class="h-8 w-8 shrink-0">
                                    No
                                    <br />
                                    icon
                                </span>
                            </button>
                        </div>

                        @foreach ($icons as $icon => $value)
                            <div class="flex items-center justify-center">
                                <button
                                    wire:click="selectIcon('{{ $icon }}')"
                                    type="button"
                                    class="group flex w-full items-center rounded-md px-4 py-2 text-base font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none md:text-sm dark:text-gray-400 dark:hover:bg-gray-600/50 dark:hover:text-gray-100"
                                    role="menuitem"
                                >
                                    <x-icon :name="$icon" size="xl" class="shrink-0"></x-icon>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-4">
                        <div class="text-center leading-normal">
                            <div class="text-gray-500 dark:text-gray-400">No icons found with the name</div>
                            <div class="mt-1 font-medium text-gray-900 dark:text-white">
                                &lsquo;{{ $search }}&rsquo;
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
