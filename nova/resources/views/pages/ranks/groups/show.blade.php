@extends($meta->template)

@section('content')
    <x-panel class="overflow-hidden">
        <x-panel.header :title="$group->name">
            <x-slot name="title">
                <div class="flex items-center gap-4">
                    <span>{{ $group->name }}</span>
                    <div class="flex items-center">
                        <x-badge :color="$group->status->color()">{{ $group->status->getLabel() }}</x-badge>
                    </div>
                </div>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', $group::class)
                    <x-button.text :href="route('ranks.groups.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan

                @can('update', $group)
                    <x-button.filled :href="route('ranks.groups.edit', $group)" color="primary" leading="edit">
                        Edit
                    </x-button.filled>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-content-box class="flex flex-col gap-4">
            <x-h3>Assigned ranks</x-h3>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                @forelse ($group->ranks as $rank)
                    <x-panel as="light-well" class="group flex w-full items-center justify-between">
                        <x-content-box height="sm" width="sm" class="w-full">
                            <div class="group flex items-center justify-between">
                                <div class="flex flex-col sm:flex-row sm:items-center">
                                    <div class="flex items-center space-x-3">
                                        <x-status :status="$rank->status"></x-status>
                                        <x-rank :rank="$rank" />
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-600 dark:text-gray-300">
                                        {{ $rank->name?->name }}
                                    </span>
                                </div>

                                @can('update', $rank)
                                    <x-button.text
                                        :href="route('ranks.items.edit', $rank)"
                                        color="gray"
                                        class="group-hover:visible sm:invisible"
                                    >
                                        <x-icon name="edit" size="sm"></x-icon>
                                    </x-button.text>
                                @endcan
                            </div>
                        </x-content-box>
                    </x-panel>
                @empty
                    <div class="col-span-2">
                        <x-empty-state.small
                            icon="rank"
                            title="No ranks assigned"
                            message="There aren't any ranks assigned to this rank group. Assign some ranks to this rank group to populate this list."
                            :link-access="gate()->allows('viewAny', Nova\Ranks\Models\RankItem::class)"
                            :link="route('ranks.items.index')"
                            label="Assign ranks"
                        ></x-empty-state.small>
                    </div>
                @endforelse
            </div>
        </x-content-box>
    </x-panel>
@endsection
