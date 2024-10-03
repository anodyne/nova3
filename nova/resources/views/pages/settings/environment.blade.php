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

        <x-form :action="route('admin.settings.environment.update')" method="PUT">
            <x-fieldset>
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

                    <x-fieldset.field
                        label="Site URL"
                        description="Use caution when changing your site’s URL as it could have unintended side effects."
                        id="url"
                        name="url"
                    >
                        <x-input.text :value="config('app.url')" placeholder="Update your site URL"></x-input.text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
