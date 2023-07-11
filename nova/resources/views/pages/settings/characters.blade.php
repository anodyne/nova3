@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Character settings">
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button.outline color="primary" leading="search" x-on:click="$dispatch('toggle-spotlight')">
                        Find a setting
                    </x-button.outline>
                </div>
            </x-slot>
        </x-panel.header>

        <x-form :action="route('settings.update', $tab)" method="PUT" id="character">
            <x-form.section title="Character creation approval">
                <x-slot name="message">
                    <p>Set whether characters of certain types require approval before being activated.</p>

                    <p>
                        <span class="font-semibold">Note:</span>
                        these settings apply to any user who has the Create Primary Characters, Create Secondary
                        Charcters, or Create Support Characters permissions.
                    </p>
                </x-slot>

                <x-input.group>
                    <x-switch-toggle
                        name="approve_primary"
                        :value="old('approve_primary', $settings->characters->approvePrimary)"
                    >
                        Primary characters
                    </x-switch-toggle>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle
                        name="approve_secondary"
                        :value="old('approve_secondary', $settings->characters->approveSecondary)"
                    >
                        Secondary characters
                    </x-switch-toggle>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle
                        name="approve_support"
                        :value="old('approve_support', $settings->characters->approveSupport)"
                    >
                        Support characters
                    </x-switch-toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Character limits"
                message="Define how many active characters a user can have linked to their account. Additional characters beyond the limit can still be created, but will require approval to be activated."
            >
                <x-input.group>
                    <x-switch-toggle
                        name="enforce_character_limits"
                        :value="old('enforce_character_limits', $settings->characters->enforceCharacterLimits)"
                    >
                        Enforce character limits
                    </x-switch-toggle>
                </x-input.group>

                <x-input.group label="Character limit">
                    <div class="w-full sm:w-2/3 md:w-2/5">
                        <x-input.number
                            id="character_limit"
                            name="character_limit"
                            :value="old('character_limit', $settings->characters->characterLimit)"
                        />
                    </div>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Automatic position availability"
                message="You can pick which character statuses will trigger Nova to automatically update position availability. If none are selected, you will need to manage the availability of positions manually."
            >
                <x-input.group>
                    <x-switch-toggle
                        name="auto_availability_primary"
                        :value="old('auto_availability_primary', $settings->characters->autoAvailabilityForPrimary)"
                    >
                        Primary characters
                    </x-switch-toggle>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle
                        name="auto_availability_secondary"
                        :value="old('auto_availability_secondary', $settings->characters->autoAvailabilityForSecondary)"
                    >
                        Secondary characters
                    </x-switch-toggle>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle
                        name="auto_availability_support"
                        :value="old('auto_availability_support', $settings->characters->autoAvailabilityForSupport)"
                    >
                        Support characters
                    </x-switch-toggle>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" form="character" color="primary">Update</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
