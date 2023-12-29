@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Character settings">
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" plain>
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('settings.characters.update')" method="PUT">
            <x-form.section title="Character creation approvals">
                <x-slot name="message">
                    <x-text>Set whether characters of certain types require approval before being activated.</x-text>
                </x-slot>

                <div class="w-full max-w-md">
                    <x-switch.group>
                        <x-switch.field>
                            <x-fieldset.label for="approve_primary">Primary characters</x-fieldset.label>
                            <x-fieldset.description>
                                Require approval for creating primary characters for users with the Create Primary
                                Characters permission in one of their roles.
                            </x-fieldset.description>
                            <x-switch
                                name="approve_primary"
                                :value="old('approve_primary', $settings->approvePrimary)"
                                id="approve_primary"
                            ></x-switch>
                        </x-switch.field>

                        <x-switch.field>
                            <x-fieldset.label for="approve_secondary">Secondary characters</x-fieldset.label>
                            <x-fieldset.description>
                                Require approval for creating secondary characters for users with the Create Secondary
                                Characters permission in one of their roles.
                            </x-fieldset.description>
                            <x-switch
                                name="approve_secondary"
                                :value="old('approve_secondary', $settings->approveSecondary)"
                                id="approve_secondary"
                            ></x-switch>
                        </x-switch.field>

                        <x-switch.field>
                            <x-fieldset.label for="approve_support">Support characters</x-fieldset.label>
                            <x-fieldset.description>
                                Require approval for creating support characters for users with the Create Support
                                Characters permission in one of their roles.
                            </x-fieldset.description>
                            <x-switch
                                name="approve_support"
                                :value="old('approve_support', $settings->approveSupport)"
                                id="approve_support"
                            ></x-switch>
                        </x-switch.field>
                    </x-switch.group>
                </div>
            </x-form.section>

            <x-form.section title="Character limits">
                <x-slot name="message">
                    <x-text>
                        Define how many active characters a user can have linked to their account. Additional characters
                        beyond the limit can still be created, but will require approval to be activated.
                    </x-text>
                </x-slot>

                <div class="flex items-center gap-x-2.5">
                    <x-switch
                        name="enforce_character_limits"
                        :value="old('enforce_character_limits', $settings->enforceCharacterLimits)"
                        id="enforce_character_limits"
                    ></x-switch>
                    <x-fieldset.label for="enforce_character_limits">Enforce character limits</x-fieldset.label>
                </div>

                <x-input.group label="Character limit">
                    <div class="w-full sm:w-2/3 md:w-2/5">
                        <x-input.number
                            id="character_limit"
                            name="character_limit"
                            :value="old('character_limit', $settings->characterLimit)"
                        />
                    </div>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Automatic position availability">
                <x-slot name="message">
                    <x-text>
                        You can pick which character statuses will trigger Nova to automatically update position
                        availability. If none are selected, you will need to manage the availability of positions
                        manually.
                    </x-text>
                </x-slot>

                <div class="flex items-center gap-x-2.5">
                    <x-switch
                        name="auto_availability_primary"
                        :value="old('auto_availability_primary', $settings->autoAvailabilityForPrimary)"
                        id="auto_availability_primary"
                    ></x-switch>
                    <x-fieldset.label for="auto_availability_primary">Primary characters</x-fieldset.label>
                </div>

                <div class="flex items-center gap-x-2.5">
                    <x-switch
                        name="auto_availability_secondary"
                        :value="old('auto_availability_secondary', $settings->autoAvailabilityForSecondary)"
                        id="auto_availability_secondary"
                    ></x-switch>
                    <x-fieldset.label for="auto_availability_secondary">Secondary characters</x-fieldset.label>
                </div>

                <div class="flex items-center gap-x-2.5">
                    <x-switch
                        name="auto_availability_support"
                        :value="old('auto_availability_support', $settings->autoAvailabilityForSupport)"
                        id="auto_availability_support"
                    ></x-switch>
                    <x-fieldset.label for="auto_availability_support">Support characters</x-fieldset.label>
                </div>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
