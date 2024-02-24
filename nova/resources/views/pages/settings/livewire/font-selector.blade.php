<x-dropdown max-height="20rem" width="md">
    <x-slot name="selectTrigger">
        {{ $family ?? 'Select a font' }}
        <input type="hidden" name="{{ $fontProviderInputName }}" value="{{ $provider }}" />
        <input type="hidden" name="{{ $fontFamilyInputName }}" value="{{ $family }}" />
    </x-slot>

    <div>
        <div class="border-b border-gray-950/10 dark:border-white/10">
            <nav class="-mb-px flex" aria-label="Tabs">
                <button
                    type="button"
                    wire:click="$set('provider', 'local')"
                    @class([
                        'w-1/3 border-b-2 px-1 py-4 text-center text-sm font-medium',
                        'border-primary-500 text-primary-600 dark:text-primary-400' => $provider === 'local',
                        'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-white' => $provider !== 'local',
                    ])
                >
                    Local
                </button>
                <button
                    type="button"
                    wire:click="$set('provider', 'bunny')"
                    @class([
                        'w-1/3 border-b-2 px-1 py-4 text-center text-sm font-medium',
                        'border-primary-500 text-primary-600 dark:text-primary-400' => $provider === 'bunny',
                        'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-white' => $provider !== 'bunny',
                    ])
                >
                    Bunny Fonts
                </button>
                <button
                    type="button"
                    wire:click="$set('provider', 'google')"
                    @class([
                        'w-1/3 border-b-2 px-1 py-4 text-center text-sm font-medium',
                        'border-primary-500 text-primary-600 dark:text-primary-400' => $provider === 'google',
                        'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-white' => $provider !== 'google',
                    ])
                >
                    Google Fonts
                </button>
            </nav>
        </div>

        @if ($provider === 'local')
            <x-fieldset class="p-4">
                <x-fieldset.heading>
                    <x-icon name="server"></x-icon>
                    <x-fieldset.legend>Local fonts</x-fieldset.legend>
                    <x-fieldset.description>Use a font that’s stored on your server</x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group>
                    <div>
                        @foreach ($localFonts as $font)
                            <x-dropdown.item type="button" wire:click="$set('family', '{{ $font }}')">
                                {{ $font }}
                            </x-dropdown.item>
                        @endforeach
                    </div>
                </x-fieldset.field-group>
            </x-fieldset>
        @endif

        @if ($provider === 'bunny')
            <x-fieldset class="p-4">
                <x-fieldset.heading>
                    <x-logos.bunny-fonts-color
                        class="h-9 w-9 md:h-8 md:w-8"
                        data-slot="icon"
                    ></x-logos.bunny-fonts-color>
                    <x-fieldset.legend>Bunny Fonts</x-fieldset.legend>
                    <x-fieldset.description>
                        <x-text.link href="https://bunny.net/fonts/" target="_blank">Bunny Fonts</x-text.link>
                        is a privacy-focused, GDPR-compliant font service. In most cases, it’s a drop-in replacement for
                        Google Fonts.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group>
                    <x-fieldset.field
                        label="Font family"
                        description="Enter the name of the font from Bunny Fonts you want to use"
                        id="button_font_bunny"
                        name="button_font_bunny"
                        wire:ignore
                    >
                        <x-input.text wire:model.live="family"></x-input.text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>
        @endif

        @if ($provider === 'google')
            <x-fieldset class="p-4">
                <x-fieldset.heading>
                    <x-logos.google-color class="h-9 w-9 md:h-8 md:w-8" data-slot="icon"></x-logos.google-color>
                    <x-fieldset.legend>Google Fonts</x-fieldset.legend>
                    <x-fieldset.description>
                        <x-text.link href="https://google.com/fonts" target="_blank">Google Fonts</x-text.link>
                        is a library of open source font families for convenient use on the web.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group>
                    <x-fieldset.field
                        label="Font family"
                        description="Enter the name of the font from Google Fonts you want to use"
                        id="button_font_google"
                        name="button_font_google"
                        wire:ignore
                    >
                        <x-input.text wire:model.live="family"></x-input.text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>
        @endif
    </div>
</x-dropdown>
