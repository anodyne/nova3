@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Add a new character">
            <x-slot name="actions">
                <x-button.text :href="route('characters.index')" leading="arrow-left" color="gray">Back</x-button.text>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('characters.store')">
            <x-form.section title="Character Info">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group label="Rank" :error="$errors->first('rank_id')">
                    <livewire:rank-items-dropdown :rank="old('rank_id')" />
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Avatar"
                message="Character avatars should be a square image at least 500 pixels tall by 500 pixels wide, but not more than 5MB in size."
            >
                <x-input.group>
                    <livewire:media:upload-avatar />
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Positions"
                message="Characters can be assigned to any number of positions. On the manifest, the character will be displayed for each position they're assigned to."
            >
                <x-panel>
                    <livewire:characters-manage-positions />
                </x-panel>
            </x-form.section>

            @can('create', Nova\Characters\Models\Character::class)
                <x-form.section
                    title="Ownership"
                    message="Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character."
                >
                    <x-panel>
                        <livewire:characters-manage-users />
                    </x-panel>
                </x-form.section>
            @else
                <x-form.section
                    title="Ownership"
                    message="Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character."
                >
                    <livewire:characters-manage-ownership />
                </x-form.section>
            @endcan

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Add</x-button.filled>
                <x-button.filled :href="route('characters.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
