@extends($meta->template)

@use('Nova\Characters\Models\Character')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Add a new character</x-slot>

            <x-slot name="actions">
                <x-button :href="route('characters.index')" plain>&larr; Back</x-button>
            </x-slot>
        </x-page-header>

        <x-form :action="route('characters.store')">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                        <x-input.text :value="old('name')" data-cy="name" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Rank" id="rank" name="rank" :error="$errors->first('rank_id')">
                        <livewire:rank-items-dropdown :rank="old('rank_id')" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Avatar" id="avatar" name="avatar">
                        <livewire:media-upload-avatar />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset title="Positions">
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Positions</x-fieldset.legend>
                        <x-fieldset.description>
                            Characters can be assigned to any number of positions. On the manifest, the character will
                            be displayed for each position they’re assigned to.
                        </x-fieldset.description>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <livewire:characters-manage-positions />
                    </x-spacing>
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Ownership</x-fieldset.legend>
                        <x-fieldset.description>
                            Characters can be assigned to any number of users and all assigned users will have the same
                            rights with the character. Additionally, any notifications on behalf of the character will
                            be sent to all users assigned to the character.
                        </x-fieldset.description>
                    </x-spacing>

                    <x-spacing size="2xs">
                        @can('create', Character::class)
                            <livewire:characters-manage-users />
                        @else
                            <livewire:characters-manage-ownership />
                        @endcan
                    </x-spacing>
                </x-panel>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('characters.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
