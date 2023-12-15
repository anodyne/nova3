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
                    <livewire:media-upload-avatar :model="$character" />
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Positions"
                message="Characters can be assigned to any number of positions. On the manifest, the character will be displayed for each position they're assigned to."
            >
                <livewire:characters-manage-positions :character="$character" />
            </x-form.section>

            <x-form.section
                title="Ownership"
                message="Characters can be assigned to any number of users and all assigned users will have the same
                rights with the character. Additionally, any notifications on behalf of the character will be
                sent to all users assigned to the character."
            >
                <livewire:characters-manage-users :character="$character" />
            </x-form.section>

            @canany(['activate', 'deactivate'], $character)
                <x-form.section title="Admin actions">
                    <x-panel class="overflow-hidden">
                        <div class="divide-y divide-gray-200 dark:divide-gray-800">
                            @can('activate', $character)
                                <x-content-box height="sm" class="grid grid-cols-3 gap-6 bg-white dark:bg-gray-900">
                                    <div class="col-span-2">
                                        <div class="flex items-center gap-2">
                                            <x-icon name="check" size="md" class="text-gray-500"></x-icon>
                                            <x-h3>Activate character</x-h3>
                                        </div>
                                        <p class="mt-2 text-sm/6 text-gray-600 dark:text-gray-400">
                                            When activating the character, if they were previously a primary character
                                            for the user, but the user has since had a new primary character set for
                                            themselves, this character will be set as a secondary character for the
                                            user.
                                        </p>
                                    </div>
                                    <div class="flex items-start justify-end">
                                        <livewire:characters-activate-button :character="$character" />
                                    </div>
                                </x-content-box>
                            @endcan

                            @can('deactivate', $character)
                                <x-content-box height="sm" class="grid grid-cols-3 gap-6 bg-white dark:bg-gray-900">
                                    <div class="col-span-2">
                                        <div class="flex items-center gap-2">
                                            <x-icon name="remove" size="md" class="text-gray-500"></x-icon>
                                            <x-h3>Deactivate character</x-h3>
                                        </div>
                                        <p class="mt-2 text-sm/6 text-gray-600 dark:text-gray-400">
                                            When deactivating the character, the owning user(s) will remain at their
                                            current status. Pay special attention to deactivating a character who is the
                                            only character assigned to a user as it may impede their ability to
                                            contribute to stories.
                                        </p>
                                    </div>
                                    <div class="flex items-start justify-end">
                                        <livewire:characters-deactivate-button :character="$character" />
                                    </div>
                                </x-content-box>
                            @endcan
                        </div>
                    </x-panel>
                </x-form.section>
            @endcanany

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.filled :href="route('characters.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
