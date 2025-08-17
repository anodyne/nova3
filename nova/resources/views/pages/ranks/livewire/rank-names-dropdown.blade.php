@use('Nova\Ranks\Models\RankName')

<div>
    <div class="flex w-full items-center gap-2">
        <x-select variant="listbox" wire:model.live="name" placeholder="Select a rank name" searchable>
            @foreach ($rankNames as $rankName)
                <x-select.option :value="$rankName->id">{{ $rankName->name }}</x-select.option>
            @endforeach
        </x-select>

        @can('create', RankName::class)
            <x-button :href="route('admin.ranks.names.index')" variant="subtle" square>
                <x-icon :name="Tabler::Settings" size="md" />
            </x-button>
        @endcan
    </div>

    <input type="hidden" name="name_id" value="{{ $name }}" />
</div>
