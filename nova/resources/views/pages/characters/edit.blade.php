@php
    $errors = $errors->getBag('default');
@endphp

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                <x-button :href="route('admin.characters.index')" variant="ghost" inset="right">
                    <span aria-hidden="true">←</span>
                    Back
                </x-button>
            </x-slot>
        </x-page-heading>

        <x-form :action="route('admin.characters.update', $character)" method="PUT">
            @if (filled($form->published_fields))
                <x-tab.group>
                    <x-slot name="tabs">
                        <x-tab name="info">
                            <x-icon :name="Tabler::InfoCircle" size="sm" />
                            Basic info
                            @if ($errors->has('name'))
                                <span class="text-danger-500 shrink-0">
                                    <x-icon.micro.alert />
                                </span>
                            @endif
                        </x-tab>
                        <x-tab name="bio">
                            <x-icon :name="Tabler::UserCircle" size="sm" />
                            Bio
                            @if ($errors->has('characterBio.*'))
                                <span class="text-danger-500 shrink-0">
                                    <x-icon.micro.alert />
                                </span>
                            @endif
                        </x-tab>
                    </x-slot>

                    <x-tab.panel name="info" class="space-y-12">
                        <x-fieldset>
                            <x-fieldset.group constrained>
                                <x-input label="Name" name="name" :value="old('name', $character->name)" />

                                <x-input.field>
                                    <x-label>Rank</x-label>
                                    <livewire:rank-items-dropdown :rank="old('rank_id', $character->rank_id)" />
                                </x-input.field>

                                <x-input.field>
                                    <x-label>Character photo</x-label>
                                    <livewire:media-upload-avatar :model="$character" />
                                </x-input.field>
                            </x-fieldset.group>
                        </x-fieldset>

                        <x-fieldset title="Positions">
                            <x-panel variant="well">
                                <x-panel.header
                                    title="Positions"
                                    description="Characters can be assigned to any number of positions. On the manifest, the character will be displayed for each position they’re assigned to."
                                ></x-panel.header>

                                <livewire:characters-manage-positions :character="$character" />
                            </x-panel>
                        </x-fieldset>

                        <x-fieldset>
                            <x-panel variant="well">
                                <x-panel.header
                                    title="Ownership"
                                    description="Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character."
                                ></x-panel.header>

                                <livewire:characters-manage-users :character="$character" />
                            </x-panel>
                        </x-fieldset>

                        @can('activate', $character)
                            <x-fieldset>
                                <x-panel color="success" variant="well">
                                    <x-panel.header
                                        title="Activate character"
                                        :icon="Tabler::CircleCheck"
                                    ></x-panel.header>

                                    <x-panel color="success">
                                        <x-spacing size="md" class="space-y-6">
                                            <x-text size="base">
                                                When activating the character, if they were previously a primary
                                                character for the user, but the user has since had a new primary
                                                character set for themselves, this character will be set as a secondary
                                                character for the user.
                                            </x-text>

                                            <livewire:characters-activate-button :character="$character" />
                                        </x-spacing>
                                    </x-panel>
                                </x-panel>
                            </x-fieldset>
                        @endcan

                        @can('deactivate', $character)
                            <x-fieldset>
                                <x-panel color="danger" variant="well">
                                    <x-panel.header
                                        title="Deactivate character"
                                        :icon="Tabler::CircleMinus"
                                    ></x-panel.header>

                                    <x-panel color="danger">
                                        <x-spacing size="md" class="space-y-6">
                                            <x-text size="base">
                                                When deactivating the character, the owning user(s) will remain at their
                                                current status. Pay special attention to deactivating a character who is
                                                the only character assigned to a user as it may impede their ability to
                                                contribute to stories.
                                            </x-text>

                                            <livewire:characters-deactivate-button :character="$character" />
                                        </x-spacing>
                                    </x-panel>
                                </x-panel>
                            </x-fieldset>
                        @endcan
                    </x-tab.panel>

                    <x-tab.panel name="bio" class="prose dark:prose-invert w-full max-w-md">
                        <livewire:dynamic-form
                            :form="$form"
                            :submission="$character->characterFormSubmission"
                            :owner="$character"
                            :admin="true"
                        />
                    </x-tab.panel>
                </x-tab.group>
            @endif

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.characters.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
