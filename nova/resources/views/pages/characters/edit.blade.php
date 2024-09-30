@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                <x-button :href="route('admin.characters.index')" plain>&larr; Back</x-button>
            </x-slot>
        </x-page-header>

        <x-form
            :action="route('admin.characters.update', $character)"
            method="PUT"
            x-data="tabsList('{{ $errors->getBag('default')->has('character.*') ? 'bio' : 'info' }}')"
        >
            @if (filled($form->published_fields))
                <x-tab.group name="character">
                    <x-tab.heading name="info">
                        <x-icon name="info" size="sm"></x-icon>
                        Basic info
                    </x-tab.heading>
                    <x-tab.heading name="bio">
                        <x-icon name="user-profile" size="sm"></x-icon>
                        Bio
                    </x-tab.heading>
                </x-tab.group>
            @endif

            <div class="space-y-12" x-show="isTab('info')">
                <x-fieldset>
                    <x-fieldset.field-group constrained>
                        <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                            <x-input.text :value="old('name', $character->name)" data-cy="name" />
                        </x-fieldset.field>

                        <x-fieldset.field label="Rank" id="rank" name="rank">
                            <livewire:rank-items-dropdown :rank="old('rank_id', $character->rank_id)" />
                        </x-fieldset.field>

                        <x-fieldset.field label="Avatar" id="avatar" name="avatar">
                            <livewire:media-upload-avatar :model="$character" />
                        </x-fieldset.field>
                    </x-fieldset.field-group>
                </x-fieldset>

                <x-fieldset title="Positions">
                    <x-panel well>
                        <x-panel.well-heading
                            heading="Positions"
                            description="Characters can be assigned to any number of positions. On the manifest, the character will be displayed for each position they’re assigned to."
                        ></x-panel.well-heading>

                        <x-spacing size="2xs">
                            <livewire:characters-manage-positions :character="$character" />
                        </x-spacing>
                    </x-panel>
                </x-fieldset>

                <x-fieldset>
                    <x-panel well>
                        <x-panel.well-heading
                            heading="Ownership"
                            description="Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character."
                        ></x-panel.well-heading>

                        <x-spacing size="2xs">
                            <livewire:characters-manage-users :character="$character" />
                        </x-spacing>
                    </x-panel>
                </x-fieldset>

                @canany(['activate', 'deactivate'], $character)
                    <x-fieldset>
                        <x-panel well>
                            <x-panel.well-heading heading="Admin actions"></x-panel.well-heading>

                            <x-spacing size="2xs">
                                <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                                    @can('activate', $character)
                                        <x-spacing size="md" class="grid grid-cols-3 gap-6">
                                            <div class="col-span-2">
                                                <div class="flex items-center gap-2">
                                                    <x-icon name="check" size="md" class="text-gray-500"></x-icon>
                                                    <x-h3>Activate character</x-h3>
                                                </div>
                                                <x-text class="mt-2">
                                                    When activating the character, if they were previously a primary
                                                    character for the user, but the user has since had a new primary
                                                    character set for themselves, this character will be set as a
                                                    secondary character for the user.
                                                </x-text>
                                            </div>
                                            <div class="flex items-start justify-end">
                                                <livewire:characters-activate-button :character="$character" />
                                            </div>
                                        </x-spacing>
                                    @endcan

                                    @can('deactivate', $character)
                                        <x-spacing size="md" class="grid grid-cols-3 gap-6">
                                            <div class="col-span-2">
                                                <div class="flex items-center gap-2">
                                                    <x-icon name="remove" size="md" class="text-gray-500"></x-icon>
                                                    <x-h3>Deactivate character</x-h3>
                                                </div>
                                                <x-text class="mt-2">
                                                    When deactivating the character, the owning user(s) will remain at
                                                    their current status. Pay special attention to deactivating a
                                                    character who is the only character assigned to a user as it may
                                                    impede their ability to contribute to stories.
                                                </x-text>
                                            </div>
                                            <div class="flex items-start justify-end">
                                                <livewire:characters-deactivate-button :character="$character" />
                                            </div>
                                        </x-spacing>
                                    @endcan
                                </x-panel>
                            </x-spacing>
                        </x-panel>
                    </x-fieldset>
                @endcanany
            </div>

            <div class="w-full max-w-md" x-show="isTab('bio')">
                <livewire:dynamic-form
                    :form="$form"
                    :submission="$character->characterFormSubmission"
                    :owner="$character"
                    :admin="true"
                />
            </div>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('admin.characters.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
