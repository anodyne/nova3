<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
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
                <x-fieldset.fields>
                    <x-input.display label="Rank group">
                        <x-text>{{ $item?->group?->name }}</x-text>
                    </x-input.display>

                    <x-input.display label="Rank name">
                        <x-text>{{ $item?->name?->name }}</x-text>
                    </x-input.display>

                    <x-input.display label="Rank image">
                        <x-rank :rank="$item" />
                    </x-input.display>

                    <x-input.display label="Status">
                        <x-badge :color="$item->status->getColor()" size="md">
                            {{ $item->status->getLabel() }}
                        </x-badge>
                    </x-input.display>
                </x-fieldset.fields>
            </x-fieldset>

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Characters assigned this rank"></x-panel.header>

                    <x-panel>
                        <x-spacing size="md">
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                @forelse ($item->characters as $character)
                                    <div class="group flex items-center justify-between">
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
                                    </div>
                                @empty
                                    <div class="col-span-2">
                                        <x-empty>
                                            <x-illustration :name="Illustration::Vulcan" />
                                            <x-empty.heading>No characters assigned</x-empty.heading>
                                            <x-empty.text>
                                                There aren’t any characters assigned to this rank item. Assign some
                                                characters to this rank item to populate this list.
                                            </x-empty.text>
                                        </x-empty>
                                    </div>
                                @endforelse
                            </div>
                        </x-spacing>
                    </x-panel>
                </x-panel>
            </x-fieldset>
        </x-form>
    </x-spacing>
</x-admin-layout>
