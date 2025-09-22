@use('Nova\Departments\Models\Position')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header :heading="$department->name">
            <x-slot name="description">
                <x-metadata.group size="md" gap="lg">
                    <x-metadata label="Status">
                        <x-badge :color="$department->status->getColor()" size="md">
                            {{ $department->status->getLabel() }}
                        </x-badge>
                    </x-metadata>
                </x-metadata.group>
            </x-slot>

            @if (filled($department->description))
                <x-slot name="intro">
                    {{ $department->description }}
                </x-slot>
            @endif

            <x-slot name="actions">
                @can('viewAny', $department::class)
                    <x-button :href="route('admin.departments.index')" variant="ghost">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                @endcan

                @can('update', $department)
                    <x-button :href="route('admin.departments.edit', $department)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm" />
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            @if (filled($department->tags))
                <x-fieldset>
                    <x-fieldset.group constrained>
                        <x-input.display label="Tags">
                            @foreach ($department->tags as $tag)
                                <x-badge size="md">{{ $tag }}</x-badge>
                            @endforeach
                        </x-input.display>
                    </x-fieldset.group>
                </x-fieldset>
            @endif

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Positions assigned to this department">
                        @can('viewAny', Position::class)
                            <x-slot name="actions">
                                <x-button
                                    :href="route('admin.positions.index', ['tableFilters' => ['department_id' => ['values' => [$department->id]]]])"
                                    variant="ghost"
                                    inset="right top bottom"
                                >
                                    Manage
                                </x-button>
                            </x-slot>
                        @endcan
                    </x-panel.header>

                    <x-panel>
                        <x-spacing.group divided>
                            @forelse ($department->positions as $position)
                                <x-panel.group.row>
                                    <div class="flex items-center gap-2">
                                        <x-status :status="$position->status" />
                                        <x-heading>{{ $position->name }}</x-heading>
                                    </div>

                                    @can('update', $position)
                                        <x-button
                                            :href="route('admin.positions.edit', $position)"
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
                                    <x-illustration :name="Illustration::HandpickResume" />
                                    <x-empty.heading>No positions assigned</x-empty.heading>
                                    <x-empty.text>
                                        There aren’t any positions assigned to this department. Assign some positions to
                                        this department to populate this list.
                                    </x-empty.text>

                                    @can('viewAny', Position::class)
                                        <x-button :href="route('admin.positions.index')" variant="ghost">
                                            Assign positions
                                            <span aria-hidden="true">→</span>
                                        </x-button>
                                    @endcan
                                </x-empty>
                            @endforelse
                        </x-spacing.group>
                    </x-panel>
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Active characters assigned to this department"></x-panel.header>

                    <x-panel>
                        <x-spacing size="md">
                            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                                @forelse ($department->activeCharacters as $character)
                                    <div class="group flex items-center justify-between">
                                        <div class="flex items-center">
                                            <x-avatar.character :character="$character" positions />
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
                                                There aren’t any characters assigned to any positions within this
                                                department. Assign some characters to positions within this department
                                                to populate this list.
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
                    <x-panel.header title="Active users assigned to this department"></x-panel.header>

                    <x-panel>
                        <x-spacing size="md">
                            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                                @forelse ($department->activeUsers as $user)
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
                                                There aren’t any active users who have a character assigned to any
                                                positions within this department. Assign some characters to positions
                                                within this department to populate this list.
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
