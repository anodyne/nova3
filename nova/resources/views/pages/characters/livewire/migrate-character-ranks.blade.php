<x-panel.group.row>
    <div class="flex flex-1 flex-col gap-1">
        <x-heading size="lg">{{ $character->name }}</x-heading>
        <x-metadata.group>
            <x-metadata label="Position" :value="$character->positions->first()?->name ?? 'None'"></x-metadata>
            <x-metadata label="Old rank" :value="$legacyRank ?? 'None'"></x-metadata>
        </x-metadata.group>
    </div>

    <div class="w-1/2">
        <livewire:rank-items-dropdown :rank="$rankId" @rank-item-selected="updateRank($event.detail.rank)" />
    </div>
</x-panel.group.row>
