<fieldset x-data="{
    provider: @entangle('provider').live,
    family: @entangle('family').live,
}">
    <legend class="sr-only">Font options</legend>

    <div class="space-y-4">
        <label
            for="font_provider_local"
            class="flex flex-col rounded-lg px-6 py-4"
            x-bind:class="{
                'shadow-md ring-1 ring-inset ring-gray-950/10 dark:bg-gray-800 dark:shadow-lg dark:ring-white/5':
                    provider === 'local',
                'transition hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer':
                    provider !== 'local',
            }"
        >
            <input
                type="radio"
                name="font_provider"
                id="font_provider_local"
                value="local"
                class="hidden"
                x-model="provider"
            />

            <div class="flex w-full appearance-none items-center justify-between">
                <div class="flex items-center gap-3 text-gray-400 dark:text-gray-500">
                    <x-icon
                        name="server"
                        size="xl"
                        x-bind:class="{ 'text-primary-500': provider === 'local' }"
                    ></x-icon>

                    <h3 class="text-left text-base font-semibold text-gray-900 dark:text-white">
                        Use a font stored on your server
                    </h3>
                </div>
                <div class="ml-8 flex shrink-0 items-center space-x-3">
                    <x-icon
                        name="add"
                        size="md"
                        class="text-gray-400 dark:text-gray-500"
                        x-show="provider !== 'local'"
                    ></x-icon>
                    <x-icon
                        name="remove"
                        size="md"
                        class="text-gray-400 dark:text-gray-500"
                        x-show="provider === 'local'"
                    ></x-icon>
                </div>
            </div>

            <div x-show="provider === 'local'" x-collapse x-cloak>
                <div class="mt-6 flex justify-between border-t border-gray-900/10 pt-6 dark:border-white/5">
                    <div class="flex w-full flex-col gap-1">
                        @foreach ($localFonts as $font)
                            <button
                                type="button"
                                class="flex w-full items-center justify-between gap-4 rounded-md px-4 py-2 odd:bg-gray-100 dark:odd:bg-gray-700/50"
                                x-on:click="family = '{{ $font }}'"
                            >
                                <div class="font-medium text-gray-600 dark:text-gray-300">
                                    {{ $font }}
                                </div>
                                <div class="shrink-0 text-primary-500" x-show="family === '{{ $font }}'">
                                    <x-icon name="check" size="md"></x-icon>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </label>

        <label
            for="font_provider_bunny"
            class="flex flex-col rounded-lg px-6 py-4"
            x-bind:class="{
                'shadow-md ring-1 ring-inset ring-gray-950/10 dark:bg-gray-800 dark:shadow-lg dark:ring-white/5':
                    provider === 'bunny',
                'transition hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer':
                    provider !== 'bunny',
            }"
        >
            <input
                type="radio"
                name="font_provider"
                id="font_provider_bunny"
                value="bunny"
                class="hidden"
                x-model="provider"
            />

            <div class="flex w-full appearance-none items-center justify-between">
                <div class="flex items-center gap-3 text-gray-400 dark:text-gray-500">
                    <x-logos.bunny-fonts class="h-auto w-9 md:w-8" x-show="provider !== 'bunny'"></x-logos.bunny-fonts>
                    <x-logos.bunny-fonts-color
                        class="h-auto w-9 md:w-8"
                        x-show="provider === 'bunny'"
                    ></x-logos.bunny-fonts-color>

                    <h3 class="text-left text-base font-semibold text-gray-900 dark:text-white">Bunny Fonts</h3>
                </div>
                <div class="ml-8 flex shrink-0 items-center space-x-3">
                    <x-icon
                        name="add"
                        size="md"
                        class="text-gray-400 dark:text-gray-500"
                        x-show="provider !== 'bunny'"
                    ></x-icon>
                    <x-icon
                        name="remove"
                        size="md"
                        class="text-gray-400 dark:text-gray-500"
                        x-show="provider === 'bunny'"
                    ></x-icon>
                </div>
            </div>

            <div x-show="provider === 'bunny'" x-collapse x-cloak>
                <div class="mt-6 flex flex-col gap-6 border-t border-gray-900/10 pt-6 dark:border-white/5">
                    <x-text>
                        <x-text.link href="https://bunny.net/fonts/" target="_blank">Bunny Fonts</x-text.link>
                        is a privacy-focused, GDPR-compliant font service. In most cases, it's a drop-in replacement for
                        Google Fonts.
                    </x-text>

                    <div wire:ignore>
                        <x-fieldset.field
                            label="Font family"
                            description="Enter the name of the font from Bunny Fonts you want to use"
                            id="button_font"
                            name="button_font"
                        >
                            <x-input.text x-model="family"></x-input.text>
                        </x-fieldset.field>
                    </div>
                </div>
            </div>
        </label>

        <label
            for="font_provider_google"
            class="flex flex-col rounded-lg px-6 py-4"
            x-bind:class="{
                'shadow-md ring-1 ring-inset ring-gray-950/10 dark:bg-gray-800 dark:shadow-lg dark:ring-white/5':
                    provider === 'google',
                'transition hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer':
                    provider !== 'google',
            }"
        >
            <input
                type="radio"
                name="font_provider"
                id="font_provider_google"
                value="google"
                class="hidden"
                x-model="provider"
            />

            <div class="flex w-full appearance-none items-center justify-between">
                <div class="flex items-center gap-3 text-gray-400 dark:text-gray-500">
                    <x-logos.google class="h-9 w-9 md:h-8 md:w-8" x-show="provider !== 'google'"></x-logos.google>
                    <x-logos.google-color
                        class="h-9 w-9 md:h-8 md:w-8"
                        x-show="provider === 'google'"
                    ></x-logos.google-color>

                    <h3 class="text-left text-base font-semibold text-gray-900 dark:text-white">Google Fonts</h3>
                </div>
                <div class="ml-8 flex shrink-0 items-center space-x-3">
                    <x-icon
                        name="add"
                        size="md"
                        class="text-gray-400 dark:text-gray-500"
                        x-show="provider !== 'google'"
                    ></x-icon>
                    <x-icon
                        name="remove"
                        size="md"
                        class="text-gray-400 dark:text-gray-500"
                        x-show="provider === 'google'"
                    ></x-icon>
                </div>
            </div>

            <div x-show="provider === 'google'" x-collapse x-cloak>
                <div
                    class="mt-6 flex flex-col justify-between gap-6 border-t border-gray-900/10 pt-6 dark:border-white/5"
                >
                    <x-text>
                        <x-text.link href="https://google.com/fonts" target="_blank">Google Fonts</x-text.link>
                        is a library of open source font families for convenient use on the web.
                    </x-text>

                    <div wire:ignore>
                        <x-fieldset.field
                            label="Font family"
                            description="Enter the name of the font from Google Fonts you want to use"
                            id="google_font"
                            name="google_font"
                        >
                            <x-input.text x-model="family"></x-input.text>
                        </x-fieldset.field>
                    </div>
                </div>
            </div>
        </label>
    </div>

    <input type="hidden" name="font_family" value="{{ $family }}" />
</fieldset>
