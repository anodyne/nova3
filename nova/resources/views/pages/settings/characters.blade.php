<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                <x-button.find-setting />
            </x-slot>
        </x-page-heading>

        <x-form :action="route('admin.settings.characters.update')" method="PUT">
            <x-fieldset>
                <x-callout.primary heading="Looking for character manifest settings?" :icon="Tabler::MasksTheater">
                    Character manifest settings can be found by going to the Design Page screen for the page the
                    character manifest block is on.
                </x-callout.primary>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::CircleCheck" heading="Character creation approvals">
                    <x-description>
                        Set whether characters of certain types require approval before being activated.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-switch
                        label="Primary characters"
                        description="Require approval for creating primary characters for users with the Create Primary Characters permission in one of their roles"
                        name="approve_primary"
                        :checked="old('approve_primary', $settings->approvePrimary)"
                    />

                    <x-switch
                        label="Secondary characters"
                        description="Require approval for creating secondary characters for users with the Create Secondary Characters permission in one of their roles"
                        name="approve_secondary"
                        :checked="old('approve_secondary', $settings->approveSecondary)"
                    />

                    <x-switch
                        label="Support characters"
                        description="Require approval for creating support characters for users with the Create Support Characters permission in one of their roles"
                        name="approve_support"
                        :checked="old('approve_support', $settings->approveSupport)"
                    />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::Forbid2" heading="Character limits">
                    <x-description>
                        Define how many active characters a user can have linked to their account. Additional characters
                        beyond the limit can still be created, but will require approval to be activated.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-switch
                        label="Enforce character limits"
                        name="enforce_character_limits"
                        :checked="old('enforce_character_limits', $settings->enforceCharacterLimits)"
                        align="left"
                    />

                    <div class="w-full sm:w-1/2">
                        <x-input.number
                            label="Character limit"
                            name="character_limit"
                            :value="old('character_limit', $settings->characterLimit)"
                        ></x-input.number>
                    </div>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::PlusMinus" heading="Automatic position availability">
                    <x-description>
                        You can pick which character statuses will trigger Nova to automatically update position
                        availability. If none are selected, you will need to manage the availability of positions
                        manually.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-switch
                        label="Primary characters"
                        name="auto_availability_primary"
                        :checked="old('auto_availability_primary', $settings->autoAvailabilityForPrimary)"
                        align="left"
                    />

                    <x-switch
                        label="Secondary characters"
                        name="auto_availability_secondary"
                        :checked="old('auto_availability_secondary', $settings->autoAvailabilityForSecondary)"
                        align="left"
                    />

                    <x-switch
                        label="Support characters"
                        name="auto_availability_support"
                        :checked="old('auto_availability_support', $settings->autoAvailabilityForSupport)"
                        align="left"
                    />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
