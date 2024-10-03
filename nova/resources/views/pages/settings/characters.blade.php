<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" color="neutral">
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-page-header>

        <x-form :action="route('admin.settings.characters.update')" method="PUT">
            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="check"></x-icon>
                    <x-fieldset.legend>Character creation approvals</x-fieldset.legend>
                    <x-fieldset.description>
                        Set whether characters of certain types require approval before being activated.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
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
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="forbid"></x-icon>
                    <x-fieldset.legend>Character limits</x-fieldset.legend>
                    <x-fieldset.description>
                        Define how many active characters a user can have linked to their account. Additional characters
                        beyond the limit can still be created, but will require approval to be activated.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <div class="flex items-center gap-x-2.5">
                        <x-switch
                            name="enforce_character_limits"
                            :value="old('enforce_character_limits', $settings->enforceCharacterLimits)"
                            id="enforce_character_limits"
                        ></x-switch>
                        <x-fieldset.label for="enforce_character_limits">Enforce character limits</x-fieldset.label>
                    </div>

                    <x-fieldset.field label="Character limit" id="character_limit" name="character_limit">
                        <x-input.number
                            :value="old('character_limit', $settings->characterLimit)"
                            class="w-full sm:w-1/3"
                        ></x-input.number>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="plus-minus"></x-icon>
                    <x-fieldset.legend>Automatic position availability</x-fieldset.legend>
                    <x-fieldset.description>
                        You can pick which character statuses will trigger Nova to automatically update position
                        availability. If none are selected, you will need to manage the availability of positions
                        manually.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
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
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
