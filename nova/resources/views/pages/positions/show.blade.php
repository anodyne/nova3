<x-admin-layout>
    <x-spacing constrained>
        <x-page-header :heading="$position->name">
            <x-slot name="description">
                <div class="flex items-center gap-x-8">
                    <x-metadata label="Department" :value="$position->department->name"></x-metadata>

                    <x-metadata label="Status">
                        <x-badge :color="$position->status->getColor()">
                            {{ $position->status->getLabel() }}
                        </x-badge>
                    </x-metadata>
                </div>
            </x-slot>

            @if (filled($position->description))
                <x-slot name="intro">
                    {{ $position->description }}
                </x-slot>
            @endif

            <x-slot name="actions">
                @can('viewAny', $position::class)
                    <x-button :href="route('admin.positions.index', 'department='.$position->department->id)" plain>
                        &larr; Back
                    </x-button>
                @endcan

                @can('update', $position)
                    <x-button :href="route('admin.positions.edit', $position)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            @if (filled($position->tags))
                <x-fieldset>
                    <x-fieldset.field-group constrained>
                        <x-fieldset.field label="Tags">
                            <div data-slot="control">
                                @foreach ($position->tags as $tag)
                                    <x-badge>{{ $tag }}</x-badge>
                                @endforeach
                            </div>
                        </x-fieldset.field>
                    </x-fieldset.field-group>
                </x-fieldset>
            @endif

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Stats"></x-panel.header>

                    <x-panel>
                        <x-spacing size="md">
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
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Active characters assigned to this position"></x-panel.header>

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
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Active users assigned to this position"></x-panel.header>

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
                </x-panel>
            </x-fieldset>
        </x-form>
    </x-spacing>
</x-admin-layout>
