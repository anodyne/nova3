<x-admin-layout>
    <x-spacing constrained>
        <x-page-header :heading="$theme->name" :description="'themes/'.$theme->location">
            <x-slot name="actions">
                <x-button x-on:click="window.history.back()" plain>&larr; Back</x-button>

                @can('update', $theme)
                    <x-button :href="route('admin.themes.edit', $theme)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-panel variant="well">
                <x-panel variant="inset">
                    <img
                        src="{{ asset('themes/'.$theme->location.'/'.$theme->preview) }}"
                        alt=""
                        class="max-h-96 w-full rounded-lg object-cover"
                    />
                </x-panel>
            </x-panel>

            <x-fieldset>
                <x-fieldset.field-group>
                    <x-fieldset.field label="Version">
                        <x-text>{{ $theme->version }}</x-text>
                    </x-fieldset.field>

                    @if (filled($theme->credits))
                        <x-fieldset.field label="Credits">
                            <x-text>{{ $theme->credits }}</x-text>
                        </x-fieldset.field>
                    @endif

                    @if (settings('appearance.theme') === $theme->location)
                        <div>
                            <x-badge color="primary">Currently selected theme for public site</x-badge>
                        </div>
                    @endif
                </x-fieldset.field-group>
            </x-fieldset>

            @if (filled($theme->repository))
                <x-fieldset>
                    <x-panel variant="well">
                        <x-panel.header
                            title="Version check info"
                            icon="tabler-broadcast"
                            description="Basic information about how the theme checks for new versions"
                        ></x-panel.header>

                        <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                            <x-spacing size="row" class="group flex items-center justify-between">
                                <div>
                                    <x-text>
                                        <x-text.strong>Latest version</x-text.strong>
                                    </x-text>

                                    @if ($theme->has_update)
                                        <x-fieldset.warning-message>Update available</x-fieldset.warning-message>
                                    @endif
                                </div>
                                <div>
                                    <x-text class="tabular-nums">{{ $theme->latest_version }}</x-text>
                                </div>
                            </x-spacing>
                            <x-spacing size="row" class="group flex items-center justify-between">
                                <div>
                                    <x-text>
                                        <x-text.strong>Checking version from</x-text.strong>
                                    </x-text>
                                </div>
                                <div>
                                    <x-text>
                                        {{ $theme->repository->type->getLabel() }}
                                    </x-text>
                                </div>
                            </x-spacing>

                            @if (filled($theme->update_url))
                                <x-spacing size="row" class="group flex items-center justify-between">
                                    <div>
                                        <x-text>
                                            <x-text.strong>URL</x-text.strong>
                                        </x-text>
                                    </div>
                                    <div>
                                        <x-button :href="$theme->update_url" color="heavy-neutral" text>
                                            Go to theme repository &rarr;
                                        </x-button>
                                    </div>
                                </x-spacing>
                            @endif
                        </x-panel>
                    </x-panel>
                </x-fieldset>
            @endif
        </x-form>
    </x-spacing>
</x-admin-layout>
