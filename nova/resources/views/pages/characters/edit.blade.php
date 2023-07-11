@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit character">
            <x-slot name="actions">
                <x-button.text :href="route('characters.index')" leading="arrow-left" color="gray">Back</x-button.text>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('characters.update', $character)" method="PUT">
            <x-form.section title="Character Info">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $character->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Rank">
                    @livewire('ranks:items-dropdown', ['rank' => old('rank_id', $character->rank_id)])
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Avatar"
                message="Character avatars should be a square image at least 500 pixels tall by 500 pixels wide, but not more than 5MB in size."
            >
                <x-input.group>
                    @livewire('media:upload-avatar', ['existingAvatar' => $character->avatarUrl, 'hasAvatar' => $character->hasAvatar])
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Positions"
                message="Characters can be assigned to any number of positions. On the manifest, the character will be displayed for each position they're assigned to."
            >
                <x-panel>
                    <livewire:characters:manage-positions :character="$character" />
                </x-panel>
            </x-form.section>

            <x-form.section
                title="Ownership"
                message="Characters can be assigned to any number of users and all assigned users will have the same
                rights with the character. Additionally, any notifications on behalf of the character will be
                sent to all users assigned to the character."
            >
                <x-panel>
                    <livewire:characters:manage-users :character="$character" />
                </x-panel>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.outline :href="route('characters.index')" color="gray">Cancel</x-button.outline>
            </x-form.footer>
        </x-form>
    </x-panel>

    {{--
        @can('deactivate', $character)
        <x-panel class="mt-8">
        <x-content-box>
        <x-h3>Deactivate character</x-h3>
        
        <div class="mt-2 sm:flex sm:items-start sm:justify-between">
        <div class="w-full text-gray-500">
        <p>
        When deactivating the character, the owning user(s) will remain at their current status. Pay special attention to deactivating a character who is the only character assigned to a user as it may impede their ability to contribute to stories.
        </p>
        </div>
        <div class="mt-5 sm:mt-0 sm:ml-8 sm:shrink-0 sm:flex sm:items-center">
        <x-form :action="route('characters.deactivate', $character)">
        <x-button.outline type="submit" color="danger">
        Deactivate
        </x-button.outline>
        </x-form>
        </div>
        </div>
        </x-content-box>
        </x-panel>
        @endcan
        
        @can('activate', $character)
        <x-panel class="mt-8">
        <x-content-box>
        <x-h3>Activate character</x-h3>
        
        <div class="mt-2 sm:flex sm:items-start sm:justify-between">
        <div class="w-full text-gray-500">
        <p>
        When activating the character, if they were previously a primary character for the user, but the user has since had a new primary character set for themselves, this character will be set as a secondary character for the user.
        </p>
        </div>
        <div class="mt-5 sm:mt-0 sm:ml-8 sm:shrink-0 sm:flex sm:items-center">
        <x-form :action="route('characters.activate', $character)">
        <x-button.outline type="submit" color="primary">
        Activate
        </x-button.outline>
        </x-form>
        </div>
        </div>
        </x-content-box>
        </x-panel>
        @endcan
    --}}
@endsection
