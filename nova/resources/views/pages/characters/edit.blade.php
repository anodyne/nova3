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
                    <livewire:rank-items-dropdown :rank="old('rank_id', $character->rank_id)" />
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
                <x-button.filled :href="route('characters.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>

    @canany(['activate', 'deactivate'], $character)
        <x-panel>
            <x-content-box class="flex flex-col gap-6">
                <h3 class="text-base/6 font-semibold text-gray-900 dark:text-white">Actions</h3>

                @can('activate', $character)
                    <x-panel as="light-well">
                        <x-content-box class="sm:flex sm:items-start sm:justify-between">
                            <h4 class="sr-only">Visa</h4>
                            <div class="sm:flex sm:items-start">
                                <x-icon name="check" size="lg"></x-icon>
                                <div class="mt-3 sm:ml-4 sm:mt-0">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        Activate character
                                    </div>
                                    <div
                                        class="mt-1 max-w-2xl text-sm text-gray-600 dark:text-gray-400 sm:flex sm:items-center"
                                    >
                                        When activating the character, if they were previously a primary character for
                                        the user, but the user has since had a new primary character set for themselves,
                                        this character will be set as a secondary character for the user.
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 sm:ml-6 sm:mt-0 sm:flex-shrink-0">
                                <x-button.filled type="button" color="neutral">Activate</x-button.filled>
                            </div>
                        </x-content-box>
                    </x-panel>
                @endcan

                @can('deactivate', $character)
                    <x-panel as="light-well">
                        <x-content-box class="sm:flex sm:items-start sm:justify-between">
                            <h4 class="sr-only">Visa</h4>
                            <div class="sm:flex sm:items-start">
                                <x-icon name="remove" size="lg"></x-icon>
                                <div class="mt-3 sm:ml-4 sm:mt-0">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        Deactivate character
                                    </div>
                                    <div
                                        class="mt-1 max-w-2xl text-sm text-gray-600 dark:text-gray-400 sm:flex sm:items-center"
                                    >
                                        When deactivating the character, the owning user(s) will remain at their current
                                        status. Pay special attention to deactivating a character who is the only
                                        character assigned to a user as it may impede their ability to contribute to
                                        stories.
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 sm:ml-6 sm:mt-0 sm:flex-shrink-0">
                                <x-button.filled type="button" color="neutral">Deactivate</x-button.filled>
                            </div>
                        </x-content-box>
                    </x-panel>
                @endcan
            </x-content-box>
        </x-panel>
    @endcanany
@endsection
