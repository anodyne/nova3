<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading :heading="$addon->name" :description="'addons/'.$addon->location">
            <x-slot name="actions">
                <x-button x-on:click="window.history.back()" variant="ghost" inset="right">
                    <span aria-hidden="true">←</span>
                    Back
                </x-button>

                @can('update', $addon)
                    <x-button :href="route('admin.addons.edit', $addon)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm" />
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-heading>

        <x-form action="">
            @if (filled($addon->preview) && Storage::disk('addons')->exists($addon->location.'/'.$addon->preview))
                <x-panel variant="well">
                    <x-panel variant="inset">
                        <img
                            src="{{ asset('addons/'.$addon->location.'/'.$addon->preview) }}"
                            alt=""
                            class="max-h-96 w-full rounded-lg object-cover"
                        />
                    </x-panel>
                </x-panel>
            @endif

            <x-fieldset>
                <x-fieldset.group>
                    <x-input.display label="Version">
                        <x-text>{{ $addon->version }}</x-text>
                    </x-input.display>

                    <x-input.display label="Type">
                        <x-badge :color="$addon->type->getColor()" size="md">
                            {{ $addon->type->getLabel() }}
                        </x-badge>
                    </x-input.display>

                    <x-input.display label="Status">
                        <x-badge :color="$addon->status->getColor()" size="md">
                            {{ $addon->status->getLabel() }}
                        </x-badge>
                    </x-input.display>

                    @if (filled($addon->credits))
                        <x-input.field label="Credits">
                            <x-text>{{ $addon->credits }}</x-text>
                        </x-input.field>
                    @endif
                </x-fieldset.group>
            </x-fieldset>

            @if (filled($addon->repository?->id))
                <x-fieldset>
                    <x-panel variant="well">
                        <x-panel.header
                            title="Version check info"
                            :icon="Tabler::Broadcast"
                            description="Basic information about how the add-on checks for new versions"
                        ></x-panel.header>

                        <x-panel>
                            <x-spacing.group divided>
                                <x-panel.group.row class="items-center">
                                    <div class="flex items-center gap-3">
                                        <x-heading>Latest version</x-heading>

                                        @if ($addon->has_update)
                                            <x-badge color="warning">Update available</x-badge>
                                        @endif
                                    </div>
                                    <x-text class="tabular-nums">{{ $addon->latest_version }}</x-text>
                                </x-panel.group.row>

                                <x-panel.group.row class="items-center">
                                    <x-heading>Checking version from</x-heading>

                                    <div>
                                        <x-badge :color="$addon->repository?->type?->getColor()">
                                            {{ $addon->repository?->type?->getLabel() }}
                                        </x-badge>
                                    </div>
                                </x-panel.group.row>

                                @if (filled($addon->update_url))
                                    <x-panel.group.row class="items-center">
                                        <x-heading>URL</x-heading>

                                        <div>
                                            <x-button
                                                :href="$addon->update_url"
                                                variant="ghost"
                                                inset="right top bottom"
                                                icon:trailing="arrow-top-right-on-square"
                                            >
                                                Go to add-on repository
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
