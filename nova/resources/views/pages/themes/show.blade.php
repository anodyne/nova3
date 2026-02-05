<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading :heading="$theme->name" :description="'themes/'.$theme->location">
            <x-slot name="actions">
                <x-button x-on:click="window.history.back()" variant="ghost">
                    <span aria-hidden="true">←</span>
                    Back
                </x-button>

                @can('update', $theme)
                    <x-button :href="route('admin.themes.edit', $theme)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm"/>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-heading>

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
                <x-fieldset.group>
                    <x-input.display label="Version">
                        <x-text>{{ $theme->version }}</x-text>
                    </x-input.display>

                    @if (filled($theme->credits))
                        <x-input.display label="Credits">
                            <x-text>{{ $theme->credits }}</x-text>
                        </x-input.display>
                    @endif

                    @if (settings('appearance.theme') === $theme->location)
                        <div>
                            <x-badge color="primary" size="md">Currently selected theme for public site</x-badge>
                        </div>
                    @endif
                </x-fieldset.group>
            </x-fieldset>

            @if (filled($theme->repository?->type) && filled($theme->repository?->id))
                <x-fieldset>
                    <x-panel variant="well">
                        <x-panel.header
                            title="Version check info"
                            :icon="Tabler::Broadcast"
                            description="Basic information about how the theme checks for new versions"
                        ></x-panel.header>

                        <x-panel>
                            <x-spacing.group divided>
                                <x-panel.group.row>
                                    <div>
                                        <x-heading>Latest version</x-heading>

                                        @if ($theme->has_update)
                                            <x-description.warning>Update available</x-description.warning>
                                        @endif
                                    </div>
                                    <div>
                                        <x-text class="tabular-nums">{{ $theme->latest_version }}</x-text>
                                    </div>
                                </x-panel.group.row>

                                <x-panel.group.row>
                                    <x-heading>Checking version from</x-heading>

                                    <div>
                                        <x-text>
                                            {{ $theme->repository->type->getLabel() }}
                                        </x-text>
                                    </div>
                                </x-panel.group.row>

                                @if (filled($theme->update_url))
                                    <x-panel.group.row>
                                        <x-heading>URL</x-heading>

                                        <div>
                                            <x-button
                                                :href="$theme->update_url"
                                                variant="ghost"
                                                inset="right top bottom"
                                            >
                                                Go to theme repository
                                                <span aria-hidden="true">→</span>
                                            </x-button>
                                        </div>
                                    </x-panel.group.row>
                                @endif
                            </x-spacing.group>
                        </x-panel>
                    </x-panel>
                </x-fieldset>
            @endif
        </x-form>
    </x-spacing>
</x-admin-layout>
