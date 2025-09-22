<x-admin-layout>
    <x-spacing constrained>
        <x-page-header :heading="$item->name->name">
            <x-slot name="description">
                <x-metadata.group size="md" gap="lg">
                    <x-metadata label="Rank group" :value="$item->group->name" />

                    <x-metadata label="Status">
                        <x-badge :color="$item->status->getColor()" size="md">
                            {{ $item->status->getLabel() }}
                        </x-badge>
                    </x-metadata>
                </x-metadata.group>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', $item::class)
                    <x-button :href="route('admin.ranks.items.index')" variant="ghost">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                @endcan

                @can('update', $item)
                    <x-button :href="route('admin.ranks.items.edit', $item)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm" />
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.group>
                    <x-input.display label="Rank image">
                        <x-rank :rank="$item" />
                    </x-input.display>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Characters assigned this rank"></x-panel.header>

                    <x-panel>
                        <x-spacing.group divided>
                            @forelse ($item->characters as $character)
                                <x-panel.group.row>
                                    <div class="flex items-center">
                                        <x-avatar.character :$character status type />
                                    </div>

                                    @can('update', $character)
                                        <x-button
                                            :href="route('admin.characters.edit', $character)"
                                            variant="subtle"
                                            inset="right top bottom"
                                            square
                                        >
                                            <x-icon :name="Tabler::Pencil" size="sm" />
                                        </x-button>
                                    @endcan
                                </x-panel.group.row>
                            @empty
                                <x-empty>
                                    <x-illustration :name="Illustration::Vulcan" />
                                    <x-empty.heading>No characters assigned</x-empty.heading>
                                    <x-empty.text>
                                        There aren’t any characters assigned to this rank item. Assign some characters
                                        to this rank item to populate this list.
                                    </x-empty.text>
                                </x-empty>
                            @endforelse
                        </x-spacing.group>
                    </x-panel>
                </x-panel>
            </x-fieldset>
        </x-form>
    </x-spacing>
</x-admin-layout>
