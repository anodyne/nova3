<div
    x-data="{ open: false }"
    @rank-items-dropdown-close.window="open = false"
    @keydown.window.escape="open = false"
    @click.away="open = false"
    class="relative inline-block text-left w-full"
>
    <input type="hidden" name="rank_id" value="{{ optional($selected)->id }}">

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
                @if (isset($selected))
                    <div class="flex items-center">
                        <x-rank :rank="$selected" />
                        <span class="ml-3">{{ $selected->name->name }}</span>
                    </div>
                @else
                    Pick a rank
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
        <div class="relative rounded-md bg-gray-1 ring-1 ring-black ring-opacity-5 max-h-60 overflow-auto z-10">
            @if (! isset($items))
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <div class="block px-4 py-2 text-xs uppercase tracking-wide font-medium text-gray-600">
                        Pick a rank group
                    </div>
                    @foreach ($groups as $group)
                        <button wire:click="selectRankGroup({{ $group->id }})" type="button" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                            {{ $group->name }}
                        </button>
                    @endforeach
                </div>
            @else
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <button wire:click="clearRankItems" type="button" class="block w-full text-left px-4 py-2 text-xs uppercase tracking-wide font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none">
                        &larr; Change selected rank group
                    </button>

                    @forelse ($items as $item)
                        <button wire:click="selectRankItem({{ $item->id }})" type="button" class="inline-flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                            <x-rank :rank="$item" />
                            <span class="ml-3">{{ $item->name->name }}</span>
                        </button>
                    @empty
                        <span class="block w-full text-left px-4 py-2 text-sm text-gray-700 focus:outline-none" role="menuitem">
                            No rank items available for this rank group
                        </span>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</div>
