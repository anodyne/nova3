@extends($meta->template)

@use('Nova\Ranks\Models\RankItem')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                @can('viewAny', $group::class)
                    <x-button :href="route('admin.ranks.groups.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $group)
                    <x-button :href="route('admin.ranks.groups.edit', $group)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Group name">
                        <x-text>{{ $group->name }}</x-text>
                    </x-fieldset.field>

                    <x-fieldset.field label="Status">
                        <div data-slot="text">
                            <x-badge :color="$group->status->color()">{{ $group->status->getLabel() }}</x-badge>
                        </div>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-panel well>
                <x-spacing size="sm">
                    <x-fieldset.legend>Ranks assigned to this group</x-fieldset.legend>
                </x-spacing>

                <x-spacing size="2xs">
                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                        @forelse ($group->ranks as $rank)
                            <x-spacing size="sm" class="group flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex items-center gap-2">
                                        <x-status :status="$rank->status"></x-status>
                                        <x-rank :rank="$rank"></x-rank>
                                    </div>
                                    <x-text class="ml-3">
                                        <x-text.strong>{{ $rank->name?->name }}</x-text.strong>
                                    </x-text>
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
                                title="No ranks found for this rank group"
                                :link="route('admin.ranks.items.create')"
                                :link-access="gate()->allows('create', RankItem::class)"
                                label="Add a rank item &rarr;"
                            ></x-empty-state.small>
                        @endforelse
                    </x-panel>
                </x-spacing>
            </x-panel>
        </x-form>
    </x-spacing>
@endsection
