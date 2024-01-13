@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">General settings</x-slot>

            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" color="neutral">
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-page-header>

        <x-form :action="route('settings.general.update')" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group class="w-full max-w-md">
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

                <x-fieldset.field-group class="w-full max-w-md">
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
                    <x-icon name="leaf"></x-icon>
                    <x-fieldset.legend>Environment settings</x-fieldset.legend>
                    <x-fieldset.description>
                        Update how Nova behaves to aid in debugging any issues you may be having.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group class="w-full max-w-md" x-data="{ environment: '{{ app()->environment() }}' }">
                    <x-fieldset.field label="Environment" id="environment" name="environment">
                        <x-select x-model="environment">
                            <option value="production">Production</option>
                            <option value="local">Local</option>
                        </x-select>

                        <x-slot name="description">
                            <span x-show="environment === 'local'">
                                The local environment is intended only for development purposes. Some features may not
                                work as expected when operating in this mode.
                            </span>
                        </x-slot>
                    </x-fieldset.field>

                    <x-switch.field>
                        <x-fieldset.label for="debug_mode">Debug mode</x-fieldset.label>
                        <x-fieldset.description>
                            Enabling debug mode will allow informational messages, warnings, and errors to be displayed
                            on screen.

                            @if (config('app.debug'))
                                <x-fieldset.error-message
                                    class="mt-2 font-semibold"
                                    x-show="environment === 'production'"
                                    x-cloak
                                >
                                    In a production environment, debug mode should always be off. If debug mode is on in
                                    production, you risk exposing sensitive configuration values to your end users.
                                </x-fieldset.error-message>
                            @endif
                        </x-fieldset.description>
                        <x-switch
                            id="debug_mode"
                            name="debug_mode"
                            :on-value="1"
                            :off-value="0"
                            :value="(int) config('app.debug')"
                        ></x-switch>
                    </x-switch.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
