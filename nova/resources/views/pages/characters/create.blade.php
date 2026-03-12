@use('Nova\Characters\Models\Character')

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

        <x-form
            :action="route('admin.characters.store')"
            x-data="tabsList('{{ $errors->has('characterBio.*') && ! $errors->has('name') ? 'bio' : 'info' }}')"
        >
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
                                <x-input label="Name" name="name" :value="old('name')" />

                                <x-input.field>
                                    <x-label>Rank</x-label>
                                    <livewire:rank-items-dropdown :rank="old('rank_id')" />
                                </x-input.field>

                                <x-input.field>
                                    <x-label>Character photo</x-label>
                                    <livewire:media-upload-avatar />
                                </x-input.field>
                            </x-fieldset.group>
                        </x-fieldset>

                        <x-fieldset title="Positions">
                            <x-panel variant="well">
                                <x-panel.header
                                    title="Positions"
                                    description="Characters can be assigned to any number of positions. On the manifest, the character will be displayed for each position they’re assigned to."
                                ></x-panel.header>

                                <livewire:characters-manage-positions />
                            </x-panel>
                        </x-fieldset>

                        <x-fieldset>
                            <x-panel variant="well">
                                <x-panel.header
                                    title="Ownership"
                                    description="Characters can be assigned to any number of users and all assigned users will have the same rights with the character. Additionally, any notifications on behalf of the character will be sent to all users assigned to the character."
                                ></x-panel.header>

                                @can('create', Character::class)
                                    <livewire:characters-manage-users />
                                @else
                                    <livewire:characters-manage-ownership />
                                @endcan
                            </x-panel>
                        </x-fieldset>
                    </x-tab.panel>

                    <x-tab.panel name="bio">
                        <livewire:dynamic-form :form="$form" :admin="true" />
                    </x-tab.panel>
                </x-tab.group>
            @endif

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button :href="route('admin.characters.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
