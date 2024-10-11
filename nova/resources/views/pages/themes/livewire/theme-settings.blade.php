<div x-data="{ open: false }" x-on:theme-settings-close="open = false" class="leading-none">
    @if ($iconTrigger)
        <x-button x-on:click.prevent="open = true" text>
            <span class="shrink-0">
                <x-icon name="settings" size="md"></x-icon>
            </span>
        </x-button>
    @else
        <x-button x-on:click.prevent="open = true">
            <x-icon name="settings" size="sm"></x-icon>
            Theme settings
        </x-button>
    @endif

    <div
        x-on:sidebar-open.window="open = true"
        x-on:sidebar-close.window="open = false"
        x-on:keydown.window.escape="open = false"
        x-show="open"
        class="fixed inset-0 z-20 overflow-hidden"
        x-cloak
    >
        <div x-show="open" class="absolute inset-0 overflow-hidden">
            <div
                x-show="open"
                x-description="Background overlay, show/hide based on slide-over state."
                x-transition:enter="duration-500 ease-in-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="duration-500 ease-in-out"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-black/25 backdrop-blur transition-opacity"
                aria-hidden="true"
            ></div>

            <section
                x-on:click.away="open = false"
                class="absolute inset-y-4 right-4 flex max-w-full pl-10"
                aria-labelledby="slide-over-heading"
            >
                <div
                    class="relative w-screen max-w-lg"
                    x-description="Slide-over panel, show/hide based on slide-over state."
                    x-show="open"
                    x-transition:enter="transition duration-500 ease-in-out"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition duration-500 ease-in-out"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                >
                    <div
                        x-description="Close button, show/hide based on slide-over state."
                        x-show="open"
                        x-transition:enter="duration-500 ease-in-out"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="duration-500 ease-in-out"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute left-0 top-0 -ml-8 flex pr-2 pt-6 sm:-ml-10 sm:pr-4"
                    >
                        <button
                            type="button"
                            x-on:click="open = false"
                            class="rounded-md text-gray-500 transition duration-200 ease-in-out hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                        >
                            <span class="sr-only">Close panel</span>
                            <x-icon name="x" size="md"></x-icon>
                        </button>
                    </div>

                    <div
                        class="flex h-full flex-col overflow-y-scroll rounded-xl bg-white shadow-xl ring-1 ring-gray-950/5 dark:bg-gray-800"
                        x-data="tabsList('notifications')"
                    >
                        <x-spacing size="md">
                            <header class="flex items-center justify-between">
                                <x-h2>{{ $theme?->name }} theme settings</x-h2>
                            </header>
                        </x-spacing>

                        <div class="relative mt-6 w-full flex-1 space-y-12 px-4 leading-normal sm:px-6">
                            <x-fieldset>
                                <x-fieldset.heading>
                                    <x-icon name="typography"></x-icon>
                                    <x-fieldset.legend>Fonts</x-fieldset.legend>
                                    <x-fieldset.description>
                                        Customize the theme by changing the fonts used.
                                    </x-fieldset.description>
                                </x-fieldset.heading>

                                <x-fieldset.field-group constrained>
                                    <x-fieldset.field
                                        label="Public headers font"
                                        id="public_font_header"
                                        name="public_font_header"
                                    >
                                        <livewire:settings-font-selector
                                            section="public"
                                            type="header"
                                            :family="$theme->settings->fonts->headerFamily"
                                            :provider="$theme->settings->fonts->headerProvider"
                                            @font-updated="fontUpdated($event.detail.data)"
                                        />
                                    </x-fieldset.field>

                                    <x-fieldset.field
                                        label="Public body font"
                                        id="public_font_body"
                                        name="public_font_body"
                                    >
                                        <livewire:settings-font-selector
                                            section="public"
                                            type="body"
                                            :family="$theme->settings->fonts->bodyFamily"
                                            :provider="$theme->settings->fonts->bodyProvider"
                                            @font-updated="fontUpdated($event.detail.data)"
                                        />
                                    </x-fieldset.field>
                                </x-fieldset.field-group>
                            </x-fieldset>

                            @if ($theme->settings->hasSettings())
                                <x-fieldset>
                                    <x-fieldset.heading>
                                        <x-icon name="preferences"></x-icon>
                                        <x-fieldset.legend>Additional theme settings</x-fieldset.legend>
                                        <x-fieldset.description>
                                            Customize various options for the theme.
                                        </x-fieldset.description>
                                    </x-fieldset.heading>

                                    <x-fieldset.field-group constrained>
                                        {{ $this->form }}
                                    </x-fieldset.field-group>
                                </x-fieldset>
                            @endif
                        </div>

                        <footer>
                            <x-spacing size="md">
                                <x-button type="button" wire:click="save" color="primary">Update</x-button>
                                <x-button type="button" x-on:click="open = false" color="neutral" plain>
                                    Cancel
                                </x-button>
                            </x-spacing>
                        </footer>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
