<x-admin-layout>
    <x-spacing constrained>
        <x-page-header :heading="$position->name">
            <x-slot name="description">
                <div class="flex items-center gap-x-8">
                    <x-metadata label="Department" :value="$position->department->name"></x-metadata>

                    <x-metadata label="Status">
                        <x-badge :color="$position->status->getColor()" size="md">
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
                    <x-button
                        :href="route('admin.positions.index', 'department='.$position->department->id)"
                        variant="ghost"
                    >
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                @endcan

                @can('update', $position)
                    <x-button :href="route('admin.positions.edit', $position)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm" />
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            @if (filled($position->tags))
                <x-fieldset>
                    <x-fieldset.fields constrained>
                        <x-input.display label="Tags">
                            @foreach ($position->tags as $tag)
                                <x-badge size="md">{{ $tag }}</x-badge>
                            @endforeach
                        </x-input.display>
                    </x-fieldset.fields>
                </x-fieldset>
            @endif

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Stats"></x-panel.header>

                    <x-panel>
                        <x-spacing size="md">
                            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
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
                                            <x-avatar.character :$character positions />
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
                                                There aren’t any characters assigned to this position. Assign some
                                                characters to the position to populate this list.
                                            </x-empty.text>
                                        </x-empty>
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
                                            <x-avatar.user :$user pronouns />
                                        </div>

                                        @can('update', $user)
                                            <x-button
                                                :href="route('admin.users.edit', $user)"
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
                                            <x-illustration :name="Illustration::Users" />
                                            <x-empty.heading>No users assigned</x-empty.heading>
                                            <x-empty.text>
                                                There aren’t any active users who have a character assigned to this
                                                position. Assign some characters to the position to populate this list.
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
