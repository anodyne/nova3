@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">
                <div class="flex items-center gap-x-2">
                    <span>{{ $item->name?->name }}</span>
                    <x-rank :rank="$item"></x-rank>
                </div>
            </x-slot>
            <x-slot name="description">
                <x-badge :color="$item->status->color()" size="md">{{ $item->status->getLabel() }}</x-badge>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', $item::class)
                    <x-button :href="route('admin.ranks.items.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $item)
                    <x-button :href="route('admin.ranks.items.edit', $item)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.field-group>
                    <x-fieldset.field>
                        <x-fieldset.label>Rank group</x-fieldset.label>
                        <x-text>{{ $item?->group?->name }}</x-text>
                    </x-fieldset.field>

                    <x-fieldset.field>
                        <x-fieldset.label>Rank name</x-fieldset.label>
                        <x-text>{{ $item?->name?->name }}</x-text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Characters assigned this rank</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel>
                            <x-spacing size="md">
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    @forelse ($item->characters as $character)
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
                                                <x-button
                                                    :href="route('admin.characters.edit', $character)"
                                                    color="neutral"
                                                    class="group-hover:visible sm:invisible"
                                                    text
                                                >
                                                    <x-icon name="edit" size="sm"></x-icon>
                                                </x-button>
                                            @endcan
                                        </div>
                                    @empty
                                        <div class="col-span-2">
                                            <x-empty-state.small
                                                icon="characters"
                                                title="No characters assigned"
                                                message="There aren’t any characters assigned to this rank item. Assign some characters to this rank item to populate this list."
                                            ></x-empty-state.small>
                                        </div>
                                    @endforelse
                                </div>
                            </x-spacing>
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </x-fieldset>
        </x-form>
    </x-spacing>
@endsection
