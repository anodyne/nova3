@extends($meta->template)

@section('content')
    <div class="mx-auto w-full max-w-2xl">
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
                    <x-input.group label="Game name">
                        <x-input.text
                            name="game_name"
                            :value="$settings->gameName"
                            placeholder="Set your game's name"
                        ></x-input.text>
                    </x-input.group>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.legend>Date format</x-fieldset.legend>
                <x-fieldset.description>
                    You can set what format you would like dates displayed in throughout Nova.
                </x-fieldset.description>
                <x-fieldset.description>
                    <x-text.strong>Example:</x-text.strong>
                    {{ format_date(now()) }}
                </x-fieldset.description>

                <x-fieldset.field-group class="w-full max-w-md">
                    <x-input.group
                        label="Date format"
                        help="To see a list of available date and time format tokens, type # followed by the token you'd like to find (e.g. month or day). You can also insert other characters into the string (such as at symbols or colons) and it will be formatted with those values."
                    >
                        <x-input.date-format
                            :value="$settings->dateFormatTags"
                            placeholder="Set date format"
                        ></x-input.date-format>
                    </x-input.group>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.legend>System settings</x-fieldset.legend>

                <x-fieldset.field-group class="w-full max-w-md" x-data="{ environment: '{{ app()->environment() }}' }">
                    <x-input.group label="Environment">
                        <x-input.select name="environment" x-model="environment">
                            <option value="production">Production</option>
                            <option value="local">Local</option>
                        </x-input.select>

                        <x-slot name="help">
                            <span x-show="environment === 'local'">
                                The local environment is intended only for development purposes. Some features may not
                                work as expected when operating in this mode.
                            </span>
                        </x-slot>
                    </x-input.group>

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

            <x-fieldset>
                <div class="flex gap-x-2 lg:flex-row-reverse">
                    <x-button type="submit" color="primary">Update</x-button>
                </div>
            </x-fieldset>
        </x-form>
    </div>
@endsection
