@use('Nova\Ranks\Models\RankItem')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                @can('viewAny', $name::class)
                    <x-button :href="route('admin.ranks.names.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $name)
                    <x-button :href="route('admin.ranks.names.edit', $name)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Name">
                        <x-text>{{ $name->name }}</x-text>
                    </x-fieldset.field>

                    <x-fieldset.field label="Status">
                        <div data-slot="text">
                            <x-badge :color="$name->status->getColor()">{{ $name->status->getLabel() }}</x-badge>
                        </div>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-panel variant="well">
                <x-panel.header title="Ranks assigned this name"></x-panel.header>

                <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                    @forelse ($name->ranks as $rank)
                        <x-spacing size="row" class="group flex items-center justify-between">
                            <div class="flex items-center gap-x-3">
                                <div class="flex items-center gap-3">
                                    <x-status :status="$rank->status"></x-status>
                                    <x-rank :rank="$rank"></x-rank>
                                </div>
                                <div class="truncate font-medium text-gray-950 dark:text-white">
                                    {{ $rank->name?->name }}
                                </div>
                            </div>

                            @can('update', $rank)
                                <x-button
                                    :href="route('admin.ranks.items.edit', $rank)"
                                    class="group-hover:visible sm:invisible"
                                    text
                                >
                                    <x-icon name="edit" size="md"></x-icon>
                                </x-button>
                            @endcan
                        </x-spacing>
                    @empty
                        <x-empty-state.small
                            icon="rank"
                            title="No ranks found for this rank name"
                            :link="route('admin.ranks.items.create')"
                            :link-access="gate()->allows('create', RankItem::class)"
                            label="Add a rank item &rarr;"
                        ></x-empty-state.small>
                    @endforelse
                </x-panel>
            </x-panel>
        </x-form>
    </x-spacing>
</x-admin-layout>
