@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">{{ $position->name }}</x-slot>
            <x-slot name="description">
                <div class="flex items-center gap-x-4">
                    <x-badge size="md">
                        {{ $position->department?->name }}
                    </x-badge>
                    <x-badge :color="$position->status->color()" size="md">
                        {{ $position->status->getLabel() }}
                    </x-badge>
                </div>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', $position::class)
                    <x-button :href="route('admin.positions.index', 'department='.$position->department->id)" plain>
                        &larr; Back
                    </x-button>

                    @can('update', $position)
                        <x-button :href="route('admin.positions.edit', $position)" color="primary">
                            <x-icon name="edit" size="sm"></x-icon>
                            Edit
                        </x-button>
                    @endcan
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            @if (filled($position->description))
                <x-fieldset>
                    <x-text size="xl">{{ $position->description }}</x-text>
                </x-fieldset>
            @endif

            <x-fieldset>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Stats</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel>
                            <x-spacing size="sm">
                                <div class="grid grid-cols-1 lg:grid-cols-3">
                                    <x-panel.stat
                                        label="Assigned characters"
                                        :value="$position->active_characters_count"
                                    ></x-panel.stat>
                                    <x-panel.stat
                                        label="Playing users"
                                        :value="$position->active_users_count"
                                    ></x-panel.stat>
                                    <x-panel.stat label="Available slots" :value="$position->available"></x-panel.stat>
                                </div>
                            </x-spacing>
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Active characters assigned to this position</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel>
                            <x-spacing size="md">
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    @forelse ($position->activeCharacters as $character)
                                        <div class="group flex items-center justify-between">
                                            <div class="flex items-center">
                                                <x-avatar.character
                                                    :character="$character"
                                                    :primary-rank="false"
                                                    :secondary-positions="true"
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
                                                message="There aren’t any characters assigned to this position. Assign some characters to the position to populate this list."
                                            ></x-empty-state.small>
                                        </div>
                                    @endforelse
                                </div>
                            </x-spacing>
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Active users assigned to this position</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel>
                            <x-spacing size="md">
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    @forelse ($position->activeUsers as $user)
                                        <div class="group flex items-center justify-between">
                                            <div class="flex items-center">
                                                <x-avatar.user :user="$user"></x-avatar.user>
                                            </div>

                                            @can('update', $user)
                                                <x-button
                                                    :href="route('admin.users.edit', $user)"
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
                                                icon="users"
                                                title="No users assigned"
                                                message="There aren’t any active users who have a character assigned to this position. Assign some characters to the position to populate this list."
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
