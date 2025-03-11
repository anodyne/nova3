<x-admin-layout>
    <x-spacing constrained>
        <x-page-header :heading="$addon->name" :description="'addons/'.$addon->location">
            <x-slot name="actions">
                <x-button x-on:click="window.history.back()" plain>&larr; Back</x-button>

                @can('update', $addon)
                    <x-button :href="route('admin.addons.edit', $addon)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            @if (filled($addon->preview))
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
                <x-fieldset.field-group>
                    <x-fieldset.field label="Version">
                        <div data-slot="text">
                            <x-text>{{ $addon->version }}</x-text>
                        </div>
                    </x-fieldset.field>

                    <x-fieldset.field label="Type">
                        <div data-slot="text">
                            <x-badge :color="$addon->type->getColor()">
                                {{ $addon->type->getLabel() }}
                            </x-badge>
                        </div>
                    </x-fieldset.field>

                    <x-fieldset.field label="Status">
                        <div data-slot="text">
                            <x-badge :color="$addon->status->getColor()">
                                {{ $addon->status->getLabel() }}
                            </x-badge>
                        </div>
                    </x-fieldset.field>

                    @if (filled($addon->credits))
                        <x-fieldset.field label="Credits">
                            <x-text>{{ $addon->credits }}</x-text>
                        </x-fieldset.field>
                    @endif
                </x-fieldset.field-group>
            </x-fieldset>

            @if (filled($addon->repository?->id))
                <x-fieldset>
                    <x-panel variant="well">
                        <x-panel.header
                            title="Version check info"
                            icon="broadcast"
                            description="Basic information about how the add-on checks for new versions"
                        ></x-panel.header>

                        <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                            <x-spacing size="row" class="group flex items-center justify-between">
                                <div class="flex items-center gap-x-3">
                                    <x-text>
                                        <x-text.strong>Latest version</x-text.strong>
                                    </x-text>

                                    @if ($addon->has_update)
                                        <x-badge color="warning">Update available</x-badge>
                                    @endif
                                </div>
                                <div>
                                    <x-text class="tabular-nums">{{ $addon->latest_version }}</x-text>
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
                                        {{ $addon->repository?->type?->getLabel() }}
                                    </x-text>
                                </div>
                            </x-spacing>

                            @if (filled($addon->update_url))
                                <x-spacing size="row" class="group flex items-center justify-between">
                                    <div>
                                        <x-text>
                                            <x-text.strong>URL</x-text.strong>
                                        </x-text>
                                    </div>
                                    <div>
                                        <x-button :href="$addon->update_url" color="heavy-neutral" text>
                                            Go to add-on repository &rarr;
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
