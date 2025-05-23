<x-spacing size="row" class="flex items-center justify-between gap-8">
    <div class="flex flex-1 flex-col">
        <x-h4>{{ $character->name }}</x-h4>
        <x-text color="subtle">
            Position:
            <span class="font-semibold">{{ $character->positions->first()?->name ?? 'None' }}</span>
        </x-text>
        <x-text color="subtle">
            Old rank:
            <span class="font-semibold">{{ $legacyRank ?? 'None' }}</span>
        </x-text>
    </div>
    <div class="w-1/2">
        <livewire:rank-items-dropdown :rank="$rankId" @rank-item-selected="updateRank($event.detail.rank)" />
    </div>
</x-spacing>
