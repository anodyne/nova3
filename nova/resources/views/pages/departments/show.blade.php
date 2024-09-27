@extends($meta->template)

@use('Nova\Departments\Models\Position')

@section('content')
    <x-spacing constrained>
        <x-page-header :$meta>
            <x-slot name="actions">
                @can('viewAny', $department::class)
                    <x-button :href="route('admin.departments.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $department)
                    <x-button :href="route('admin.departments.edit', $department)" color="primary">
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
                        <x-text>{{ $department->name }}</x-text>
                    </x-fieldset.field>

                    @if (filled($department->description))
                        <x-fieldset.field label="Description">
                            <x-text>{{ $department->description }}</x-text>
                        </x-fieldset.field>
                    @endif

                    <x-fieldset.field label="Status">
                        <div data-slot="text">
                            <x-badge :color="$department->status->color()">
                                {{ $department->status->getLabel() }}
                            </x-badge>
                        </div>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-panel well>
                    <x-spacing size="sm">
                        <div class="flex items-center justify-between gap-6">
                            <x-fieldset.legend>Positions assigned to this department</x-fieldset.legend>

                            @can('viewAny', Position::class)
                                <x-button
                                    :href="route('admin.positions.index', ['tableFilters' => ['department_id' => ['values' => [$department->id]]]])"
                                    size="xs"
                                    plain
                                >
                                    Manage
                                </x-button>
                            @endcan
                        </div>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                            @forelse ($department->positions as $position)
                                <x-spacing size="sm" class="group flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <x-status :status="$position->status"></x-status>
                                        <x-text>
                                            <x-text.strong>{{ $position->name }}</x-text.strong>
                                        </x-text>
                                    </div>
                                    @can('update', $position)
                                        <x-button
                                            :href="route('admin.positions.edit', $position)"
                                            class="group-hover:visible sm:invisible"
                                            color="neutral"
                                            text
                                        >
                                            <x-icon name="edit" size="sm"></x-icon>
                                        </x-button>
                                    @endcan
                                </x-spacing>
                            @empty
                                <x-empty-state.small
                                    icon="list"
                                    title="No positions assigned"
                                    message="There aren’t any positions assigned to this department. Assign some positions to this department to populate this list."
                                    :link-access="gate()->allows('viewAny', Position::class)"
                                    :link="route('admin.positions.index')"
                                    label="Assign positions &rarr;"
                                ></x-empty-state.small>
                            @endforelse
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Active characters assigned to this department</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel>
                            <x-spacing size="md">
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    @forelse ($department->activeCharacters as $character)
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
                                                message="There aren’t any characters assigned to any positions within this department. Assign some characters to positions within this department to populate this list."
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
                        <x-fieldset.legend>Active users assigned to this department</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel>
                            <x-spacing size="md">
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    @forelse ($department->activeUsers as $user)
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
                                                message="There aren’t any active users who have a character assigned to any positions within this department. Assign some characters to positions within this department to populate this list."
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
