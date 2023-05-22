<div
    x-data="{ open: false }"
    @rank-items-dropdown-close.window="open = false"
    @keydown.window.escape="open = false"
    @click.away="open = false"
    class="relative inline-block text-left w-full leading-0"
>
    <input type="hidden" name="rank_id" value="{{ $selected?->id }}">

    <div>
        <span class="relative flex w-full rounded-md shadow-sm">
            <button
                @click="open = !open"
                type="button"
                @class([
                    'flex items-center justify-between cursor-default relative w-full rounded-md border border-gray-300 dark:border-gray-200/[15%] focus-within:ring-1 focus-within:ring-primary-400 focus-within:border-primary-400 dark:focus-within:border-primary-600 dark:focus-within:ring-primary-600 bg-white dark:bg-gray-700/50 py-2 px-3 text-left focus:outline-none dark:focus:bg-gray-800 transition leading-normal space-x-4',
                    'text-gray-900 dark:text-gray-100' => $selected,
                ])
                aria-haspopup="true"
                aria-expanded="true"
                :aria-expanded="open"
            >
                @if (isset($selected))
                    <div class="flex items-center">
                        <x-rank :rank="$selected" />
                        <span class="ml-3">{{ $selected->name->name }}</span>
                    </div>
                @else
                    Pick a rank
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
            @if (! isset($items))
                <div class="p-1.5" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <div class="block px-2 pt-3 pb-1.5 text-xs text-gray-400 uppercase tracking-wide font-semibold">
                        Pick a rank group
                    </div>
                    @foreach ($groups as $group)
                        <button wire:click="selectRankGroup({{ $group->id }})" type="button" class="group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600/50 dark:hover:text-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                            {{ $group->name }}
                        </button>
                    @endforeach
                </div>
            @else
                <div class="p-1.5" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <button wire:click="clearRankItems" type="button" class="inline-flex items-center w-full rounded-md text-left px-4 py-2 text-xs uppercase tracking-wide font-semibold text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600/50 dark:hover:text-gray-100 hover:text-gray-900 focus:outline-none">
                        &larr; Change selected rank group
                    </button>

                    @forelse ($items as $item)
                        <button wire:click="selectRankItem({{ $item->id }})" type="button" class="group rounded-md flex items-center w-full px-4 py-2 text-base md:text-sm font-medium transition text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600/50 dark:hover:text-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                            <x-rank :rank="$item" />
                            <span class="ml-3">{{ $item->name->name }}</span>
                        </button>
                    @empty
                        <span class="block px-4 py-3 text-sm text-gray-600 dark:text-gray-400" role="menuitem">
                            No rank items available for this rank group
                        </span>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</div>
