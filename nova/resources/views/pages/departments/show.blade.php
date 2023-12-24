@extends($meta->template)

@section('content')
    <x-panel class="overflow-hidden">
        <x-panel.header>
            <x-slot name="title">
                <div class="flex items-center gap-4">
                    <span>{{ $department->name }}</span>
                    <div class="flex items-center">
                        <x-badge :color="$department->status->color()">
                            {{ $department->status->getLabel() }}
                        </x-badge>
                    </div>
                </div>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', Nova\Departments\Models\Department::class)
                    <x-button.text :href="route('departments.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan

                @can('update', $department)
                    <x-button.filled :href="route('departments.edit', $department)" leading="edit" color="primary">
                        Edit
                    </x-button.filled>
                @endcan
            </x-slot>
        </x-panel.header>

        <div class="flex flex-col divide-gray-200 lg:flex-row lg:divide-x">
            <div class="flex flex-1 flex-col gap-6 divide-y divide-gray-200">
                @if (filled($department->description))
                    <x-content-box>
                        <div class="max-w-xl">
                            <x-text size="xl">{{ $department->description }}</x-text>
                        </div>
                    </x-content-box>
                @endif

                <x-content-box>
                    <div class="grid grid-cols-1 lg:grid-cols-3">
                        <x-panel.stat label="Assigned positions" :value="$department->positions_count"></x-panel.stat>
                        <x-panel.stat
                            label="Assigned characters"
                            :value="$department->active_characters_count"
                        ></x-panel.stat>
                        <x-panel.stat label="Playing users" :value="$department->active_users_count"></x-panel.stat>
                    </div>
                </x-content-box>

                <x-content-box class="flex flex-col gap-4">
                    <x-h3>Characters</x-h3>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                        @forelse ($department->activeCharacters as $character)
                            <x-panel as="light-well" class="group flex w-full items-center justify-between">
                                <x-content-box height="sm" width="sm">
                                    <x-avatar.character
                                        :character="$character"
                                        :primary-rank="false"
                                        :secondary-positions="true"
                                    ></x-avatar.character>
                                </x-content-box>
                            </x-panel>
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
                </x-content-box>

                <x-content-box class="flex flex-col gap-4">
                    <x-h3>Users</x-h3>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                        @forelse ($department->activeUsers as $user)
                            <x-panel as="light-well" class="group flex w-full items-center justify-between">
                                <x-content-box height="sm" width="sm">
                                    <x-avatar.user :user="$user"></x-avatar.user>
                                </x-content-box>
                            </x-panel>
                        @empty
                            <div class="col-span-2">
                                <x-empty-state.small
                                    icon="users"
                                    title="No active users assigned"
                                    message="There aren’t any active users who have a character assigned to any positions within this department. Assign some characters to positions within this department to populate this list."
                                ></x-empty-state.small>
                            </div>
                        @endforelse
                    </div>
                </x-content-box>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="flex w-full flex-col">
                    <div class="flex items-center justify-between px-4 py-4">
                        <x-h3>Positions</x-h3>

                        @can('viewAny', Nova\Departments\Models\Position::class)
                            <x-button.filled
                                :href="route('positions.index', ['tableFilters' => ['department_id' => ['values' => [$department->id]]]])"
                                color="neutral"
                                size="xs"
                            >
                                Manage
                            </x-button.filled>
                        @endcan
                    </div>

                    <div>
                        @forelse ($department->positions as $position)
                            <div
                                class="group flex items-center justify-between px-4 py-2 odd:bg-gray-100 dark:odd:bg-gray-700/50"
                            >
                                <div class="flex items-center gap-3">
                                    <x-status :status="$position->status"></x-status>
                                    <span>{{ $position->name }}</span>
                                </div>
                                @can('update', $position)
                                    <x-button.text
                                        :href="route('positions.edit', $position)"
                                        color="gray"
                                        class="shrink-0 group-hover:visible sm:invisible"
                                    >
                                        <x-icon name="edit" size="sm"></x-icon>
                                    </x-button.text>
                                @endcan
                            </div>
                        @empty
                            <div class="px-4">
                                <x-empty-state.small
                                    icon="list"
                                    title="No positions assigned"
                                    message="There aren’t any positions assigned to this department. Assign some positions to this department to populate this list."
                                    :link-access="gate()->allows('viewAny', Nova\Departments\Models\Position::class)"
                                    :link="route('positions.index')"
                                    label="Assign positions"
                                ></x-empty-state.small>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </x-panel>
@endsection
