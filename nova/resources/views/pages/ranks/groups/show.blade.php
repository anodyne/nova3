@use('Nova\Ranks\Models\RankItem')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                @can('viewAny', $group::class)
                    <x-button :href="route('admin.ranks.groups.index')" variant="ghost">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                @endcan

                @can('update', $group)
                    <x-button :href="route('admin.ranks.groups.edit', $group)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.fields constrained>
                    <x-input.display label="Group name">
                        <x-text>{{ $group->name }}</x-text>
                    </x-input.display>

                    <x-input.display label="Status">
                        <x-badge :color="$group->status->getColor()" size="md">
                            {{ $group->status->getLabel() }}
                        </x-badge>
                    </x-input.display>
                </x-fieldset.fields>
            </x-fieldset>

            <x-panel variant="well">
                <x-panel.header title="Ranks assigned to this group"></x-panel.header>

                <x-panel>
                    <x-panel.group divided>
                        @forelse ($group->ranks as $rank)
                            <x-panel.group.row>
                                <div class="flex items-center gap-3">
                                    <x-rank :$rank />

                                    <div class="flex flex-col gap-0.5">
                                        <x-heading>
                                            {{ $rank->name?->name }}
                                        </x-heading>

                                        <x-badge :color="$rank->status->getColor()">
                                            {{ $rank->status->getLabel() }}
                                        </x-badge>
                                    </div>
                                </div>

                                @can('update', $rank)
                                    <x-button
                                        :href="route('admin.ranks.items.edit', $rank)"
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
                                <x-illustration :name="Illustration::MilitaryRank" />
                                <x-empty.heading>No ranks found for this rank group</x-empty.heading>

                                @can('create', RankItem::class)
                                    <x-button :href="route('admin.ranks.items.create')" variant="ghost">
                                        Add a rank item
                                        <span aria-hidden="true">→</span>
                                    </x-button>
                                @endcan
                            </x-empty>
                        @endforelse
                    </x-panel.group>
                </x-panel>
            </x-panel>
        </x-form>
    </x-spacing>
</x-admin-layout>
