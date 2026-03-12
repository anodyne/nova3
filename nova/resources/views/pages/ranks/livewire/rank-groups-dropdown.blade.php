@use('Nova\Ranks\Models\RankGroup')

<div>
    <div class="flex w-full items-center gap-2">
        <x-select variant="listbox" wire:model.live="group" placeholder="Select a rank group" searchable>
            @foreach ($rankGroups as $rankGroup)
                <x-select.option :value="$rankGroup->id">{{ $rankGroup->name }}</x-select.option>
            @endforeach
        </x-select>

        @can('create', RankGroup::class)
            <x-button :href="route('admin.ranks.groups.index')" variant="subtle" square>
                <x-icon :name="Tabler::Settings" size="md" />
            </x-button>
        @endcan
    </div>

    <input type="hidden" name="group_id" value="{{ $group }}" />
</div>
