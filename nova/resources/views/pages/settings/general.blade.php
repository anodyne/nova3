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

        <x-form :action="route('admin.settings.general.update')" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Game name" id="game_name" name="game_name">
                        <x-input.text :value="$settings->gameName" placeholder="Set your game's name"></x-input.text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="calendar"></x-icon>
                    <x-fieldset.legend>Date format</x-fieldset.legend>
                    <x-fieldset.description>
                        Set the format for all dates display throughout Nova.

                        <x-fieldset.description class="mt-2">
                            <x-text.strong>Example:</x-text.strong>
                            {{ format_date(now()) }}
                        </x-fieldset.description>
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field
                        label="Date format"
                        description="To see a list of available date and time format tokens, type # followed by the token you’d like to find (e.g. month or day). You can also insert other characters into the string (such as at symbols or colons) and it will be formatted with those values."
                        id="date_format_tags"
                        name="dateFormatTags"
                    >
                        <x-input.date-format
                            :value="$settings->dateFormatTags"
                            placeholder="Set date format"
                        ></x-input.date-format>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="send"></x-icon>
                    <x-fieldset.legend>Contact form</x-fieldset.legend>
                    <x-fieldset.description>
                        Manage the settings for how outside users contact the game.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-switch.group>
                        <x-switch.field>
                            <x-fieldset.label for="contactFormEnabled">Contact form enabled</x-fieldset.label>
                            <x-fieldset.description>Allow outside users to contact the game</x-fieldset.description>
                            <x-switch
                                name="contactFormEnabled"
                                :value="old('contactFormEnabled', $settings->contactFormEnabled)"
                                id="contactFormEnabled"
                            ></x-switch>
                        </x-switch.field>
                    </x-switch.group>
                </x-fieldset.field-group>

                <x-fieldset.field-group>
                    <x-fieldset.field
                        label="Disabled message"
                        description="This is the message users will see when the contact form is disabled"
                        id="contact_form_disabled_message"
                        name="contact_form_disabled_message"
                    >
                        <x-input.textarea rows="3">{{ $settings->contactFormDisabledMessage }}</x-input.textarea>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Site contact recipients"
                        id="contact_form_recipients"
                        name="contact_form_recipients"
                    >
                        <x-text>
                            Any user that has the
                            <code class="font-mono font-semibold">site.contact</code>
                            permission will receive the site contact messages.
                        </x-text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
