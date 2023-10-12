@extends($meta->template)

@section('content')
    <x-panel class="overflow-hidden">
        <x-panel.header :message="$item->group?->name">
            <x-slot name="title">
                <div class="flex items-center gap-4">
                    <span>{{ $item->name?->name }}</span>
                    <div>
                        <x-rank :rank="$item"></x-rank>
                    </div>
                    <div class="flex items-center">
                        <x-badge :color="$item->status->color()">{{ $item->status->getLabel() }}</x-badge>
                    </div>
                </div>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', Nova\Ranks\Models\RankItem::class)
                    <x-button.text :href="route('ranks.items.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan

                @can('update', $item)
                    <x-button.filled :href="route('ranks.items.edit', $item)" color="primary" leading="edit">
                        Edit
                    </x-button.filled>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-content-box class="flex flex-col gap-4">
            <x-h3>Assigned characters</x-h3>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                @forelse ($item->characters as $character)
                    <x-panel as="light-well" class="group flex w-full items-center justify-between">
                        <x-content-box height="sm" width="sm" class="w-full">
                            <div class="group flex items-center justify-between">
                                <div class="flex items-center">
                                    <x-avatar.character
                                        :character="$character"
                                        :primary-status="true"
                                        :primary-rank="false"
                                        :secondary-positions="false"
                                        :secondary-type="true"
                                    ></x-avatar.character>
                                </div>

                                @can('update', $character)
                                    <x-button.text
                                        :href="route('characters.edit', $character)"
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
                            icon="characters"
                            title="No characters assigned"
                            message="There aren't any characters assigned to this rank item. Assign some characters to this rank item to populate this list."
                        ></x-empty-state.small>
                    </div>
                @endforelse
            </div>
        </x-content-box>
    </x-panel>
@endsection
