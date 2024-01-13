<x-dropdown max-height="15rem" width="md">
    <x-slot name="selectTrigger">
        @if (filled($selected))
            <div class="flex items-center">
                <x-rank :rank="$selected" />
                <span class="ml-3">{{ $selected?->name?->name }}</span>
            </div>
        @else
            Pick a rank
        @endif

        <input type="hidden" name="rank_id" value="{{ $selected?->id }}" />
    </x-slot>

    @if (! isset($items))
        @if ($selected)
            <x-dropdown.group>
                <x-dropdown.item wire:click="selectRankItem(null)" icon="x">Clear selected rank</x-dropdown.item>
            </x-dropdown.group>
        @endif

        <x-dropdown.group>
            <x-dropdown.text>Pick a rank group</x-dropdown.text>
            @foreach ($groups as $group)
                <x-dropdown.item wire:click="selectRankGroup({{ $group->id }})">
                    {{ $group->name }}
                </x-dropdown.item>
            @endforeach
        </x-dropdown.group>
    @else
        <x-dropdown.group>
            <x-dropdown.item wire:click="clearRankItems">&larr; Change selected rank group</x-dropdown.item>

            @forelse ($items as $item)
                <x-dropdown.item wire:click="selectRankItem({{ $item->id }})">
                    <x-rank :rank="$item" />
                    <span class="ml-3">{{ $item->name->name }}</span>
                </x-dropdown.item>
            @empty
                <span class="block px-4 py-3 text-sm text-gray-600 dark:text-gray-400" role="menuitem">
                    No rank items available for this rank group
                </span>
            @endforelse
        </x-dropdown.group>
    @endif
</x-dropdown>
