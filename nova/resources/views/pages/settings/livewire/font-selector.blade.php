<div>
    <x-dropdown class="max-h-96 w-96 max-w-96">
        <x-slot name="trigger">
            <button
                type="button"
                class="h-10 appearance-none rounded-lg border border-gray-200 border-b-gray-300/80 bg-white px-3 py-2 text-base leading-[1.375rem] shadow-xs sm:text-sm dark:border-white/10 dark:bg-white/10"
            >
                <x-metadata.group class="leading-none">
                    <x-metadata label="Family" :value="$family"></x-metadata>
                    <x-metadata label="Provider" :value="ucfirst($provider)"></x-metadata>
                </x-metadata.group>
            </button>

            <input type="hidden" name="{{ $fontProviderInputName }}" value="{{ $provider }}"/>
            <input type="hidden" name="{{ $fontFamilyInputName }}" value="{{ $family }}"/>
        </x-slot>

        <div>
            <x-radio.group wire:model.live="provider" variant="segmented" keep-open>
                <x-radio label="Local" value="local"/>
                <x-radio label="Bunny Fonts" value="bunny"/>
                <x-radio label="Google Fonts" value="google"/>
            </x-radio.group>

            @if ($provider === 'local')
                <x-dropdown.text>
                    <x-fieldset.heading :icon="Tabler::Server" heading="Local fonts">
                        <x-description>Use a font that’s stored on your server</x-description>
                    </x-fieldset.heading>
                </x-dropdown.text>

                <flux:menu.radio.group wire:model.live="family">
                    @foreach ($localFonts as $font)
                        <flux:menu.radio :value="$font">
                            {{ $font }}
                        </flux:menu.radio>
                    @endforeach
                </flux:menu.radio.group>
            @endif

            @if ($provider === 'bunny')
                <x-fieldset class="p-4">
                    <x-fieldset.heading heading="Bunny Fonts">
                        <x-slot name="icon">
                            <x-logos.bunny-fonts-color class="size-7" data-slot="icon"/>
                        </x-slot>

                        <x-description>
                            <x-link href="https://bunny.net/fonts/" target="_blank" underline>Bunny Fonts</x-link>
                            is a privacy-focused, GDPR-compliant font service. In most cases, it’s a drop-in replacement
                            for Google Fonts.
                        </x-description>
                    </x-fieldset.heading>

                    <x-fieldset.group>
                        <x-field>
                            <x-label>Font family</x-label>
                            <x-description>Enter the name of the font from Bunny Fonts</x-description>
                            <x-input name="button_font_bunny" wire:model.live.debounce="family"/>
                        </x-field>
                    </x-fieldset.group>
                </x-fieldset>
            @endif

            @if ($provider === 'google')
                <x-fieldset class="p-4">
                    <x-fieldset.heading heading="Google Fonts">
                        <x-slot name="icon">
                            <x-logos.google-color class="size-7" data-slot="icon"/>
                        </x-slot>

                        <x-description>
                            <x-link href="https://google.com/fonts" target="_blank" underline>Google Fonts</x-link>
                            is a library of open source font families for convenient use on the web.
                        </x-description>
                    </x-fieldset.heading>

                    <x-fieldset.group>
                        <x-field>
                            <x-label>Font family</x-label>
                            <x-description>Enter the name of the font from Google Fonts</x-description>
                            <x-input name="button_font_google" wire:model.live.debounce="family"/>
                        </x-field>
                    </x-fieldset.group>
                </x-fieldset>
            @endif
        </div>
    </x-dropdown>
</div>
