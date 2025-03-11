@use('Nova\Ranks\Models\RankName')

<div data-slot="control">
    <div class="flex w-full items-center gap-x-3">
        <flux:select variant="listbox" wire:model.live="name" placeholder="Select a rank name" searchable>
            @foreach ($rankNames as $rankName)
                <flux:option value="{{ $rankName->id }}">{{ $rankName->name }}</flux:option>
            @endforeach
        </flux:select>

        @can('create', RankName::class)
            <x-button :href="route('admin.ranks.names.index')" color="neutral" text>
                <x-icon name="settings" size="md"></x-icon>
            </x-button>
        @endcan
    </div>

    <input type="hidden" name="name_id" value="{{ $name }}" />
</div>
