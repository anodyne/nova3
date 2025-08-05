@use('Nova\Ranks\Models\RankGroup')

<div data-slot="control">
    <div class="flex w-full items-center gap-x-3">
        <flux:select variant="listbox" wire:model.live="group" placeholder="Select a rank group" searchable>
            @foreach ($rankGroups as $rankGroup)
                <flux:select.option value="{{ $rankGroup->id }}">{{ $rankGroup->name }}</flux:select.option>
            @endforeach
        </flux:select>

        @can('create', RankGroup::class)
            <x-button :href="route('admin.ranks.groups.index')" color="neutral" text>
                <x-icon :name="Icon::Settings" size="md"></x-icon>
            </x-button>
        @endcan
    </div>

    <input type="hidden" name="group_id" value="{{ $group }}" />
</div>
