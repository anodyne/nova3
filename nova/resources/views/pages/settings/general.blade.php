<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                <x-button.find-setting />
            </x-slot>
        </x-page-heading>

        <x-form :action="route('admin.settings.general.update')" method="PUT">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input
                        label="Game name"
                        name="game_name"
                        :value="old('game_name', $settings->gameName)"
                        placeholder="Set your game’s name"
                    ></x-input>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::Send" heading="Contact form">
                    <x-description>Manage the settings for how outside users contact the game.</x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-switch
                        label="Contact form enabled"
                        description="Allow outside users to contact the game"
                        name="contactFormEnabled"
                        :checked="old('contactFormEnabled', $settings->contactFormEnabled)"
                    ></x-switch>
                </x-fieldset.group>

                <x-fieldset.group>
                    <x-textarea
                        label="Disabled message"
                        description="This is the message users will see when the contact form is disabled"
                        name="contact_form_disabled_message"
                        rows="3"
                    >
                        {{ $settings->contactFormDisabledMessage }}
                    </x-textarea>

                    <x-field>
                        <x-label>Site contact recipients</x-label>

                        <x-text>
                            Any user that has the
                            <code class="font-mono font-semibold">site.contact</code>
                            permission will receive the site contact messages.
                        </x-text>
                    </x-field>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
