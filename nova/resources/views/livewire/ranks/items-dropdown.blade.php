<div x-data="{ open: false }" x-on:rank-items-dropdown-close.window="open = false" x-on:keydown.window.escape="open = false" x-on:click.away="open = false" class="relative inline-block w-full text-left leading-0">
    <input type="hidden" name="rank_id" value="{{ $selected?->id }}" />

    <div>
        <span class="relative flex w-full rounded-md shadow-sm">
            <button x-on:click="open = !open" type="button" @class([
                'relative flex w-full cursor-default items-center justify-between space-x-4 rounded-md bg-white px-3 py-2.5 text-left leading-normal ring-1 ring-inset ring-gray-300 transition focus-within:ring-2 focus-within:ring-inset focus-within:ring-primary-600 focus:outline-none dark:bg-opacity-5 dark:ring-white/10 dark:focus-within:ring-primary-500',
                'text-gray-900 dark:text-white' => $selected,
            ]) aria-haspopup="true" aria-expanded="true" :aria-expanded="open">
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

    <div x-show="open" x-description="Dropdown panel, show/hide based on dropdown state." x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 mt-2 w-full origin-top-left rounded-lg shadow-lg" x-cloak>
        <div class="relative z-10 max-h-60 divide-y divide-gray-100 overflow-auto rounded-lg bg-white ring-1 ring-gray-900/5 dark:divide-gray-700 dark:bg-gray-700 dark:ring-gray-700 dark:highlight-white/10">
            @if (! isset($items))
                <div class="p-1.5" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <div class="block px-2 pb-1.5 pt-3 text-xs font-semibold text-gray-500">Pick a rank group</div>
                    @foreach ($groups as $group)
                        <button wire:click="selectRankGroup({{ $group->id }})" type="button" class="group flex w-full items-center rounded-md px-4 py-2 text-base font-medium text-gray-500 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-600/50 dark:hover:text-gray-100 md:text-sm" role="menuitem">
                            {{ $group->name }}
                        </button>
                    @endforeach
                </div>
            @else
                <div class="p-1.5" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <button wire:click="clearRankItems" type="button" class="inline-flex w-full items-center rounded-md px-4 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-600/50 dark:hover:text-gray-100">&larr; Change selected rank group</button>

                    @forelse ($items as $item)
                        <button wire:click="selectRankItem({{ $item->id }})" type="button" class="group flex w-full items-center rounded-md px-4 py-2 text-base font-medium text-gray-500 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-600/50 dark:hover:text-gray-100 md:text-sm" role="menuitem">
                            <x-rank :rank="$item" />
                            <span class="ml-3">{{ $item->name->name }}</span>
                        </button>
                    @empty
                        <span class="block px-4 py-3 text-sm text-gray-600 dark:text-gray-400" role="menuitem">No rank items available for this rank group</span>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</div>
