@extends($meta->template)

@use('Nova\Ranks\Models\RankItem')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">{{ $name->name }}</x-slot>
            <x-slot name="description">
                <x-badge :color="$name->status->color()" size="md">{{ $name->status->getLabel() }}</x-badge>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', $name::class)
                    <x-button :href="route('ranks.names.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $name)
                    <x-button :href="route('ranks.names.edit', $name)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-panel well>
            <x-spacing size="sm">
                <x-fieldset.legend>Ranks assigned this name</x-fieldset.legend>
            </x-spacing>

            <x-spacing size="2xs">
                <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                    @forelse ($name->ranks as $rank)
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
                                    :href="route('ranks.items.edit', $rank)"
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
                            :link="route('ranks.items.create')"
                            :link-access="gate()->allows('create', RankItem::class)"
                            label="Add a rank item &rarr;"
                        ></x-empty-state.small>
                    @endforelse
                </x-panel>
            </x-spacing>
        </x-panel>
    </x-spacing>
@endsection
