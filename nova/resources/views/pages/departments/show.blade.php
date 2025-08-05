@use('Nova\Departments\Models\Position')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header :heading="$department->name">
            <x-slot name="description">
                <div class="flex items-center gap-x-8">
                    <x-metadata label="Status">
                        <x-badge :color="$department->status->getColor()">
                            {{ $department->status->getLabel() }}
                        </x-badge>
                    </x-metadata>
                </div>
            </x-slot>

            @if (filled($department->description))
                <x-slot name="intro">
                    {{ $department->description }}
                </x-slot>
            @endif

            <x-slot name="actions">
                @can('viewAny', $department::class)
                    <x-button :href="route('admin.departments.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $department)
                    <x-button :href="route('admin.departments.edit', $department)" color="primary">
                        <x-icon :name="Icon::Edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            @if (filled($department->tags))
                <x-fieldset>
                    <x-fieldset.field-group constrained>
                        <x-fieldset.field label="Tags">
                            <div data-slot="control">
                                @foreach ($department->tags as $tag)
                                    <x-badge>{{ $tag }}</x-badge>
                                @endforeach
                            </div>
                        </x-fieldset.field>
                    </x-fieldset.field-group>
                </x-fieldset>
            @endif

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Positions assigned to this department">
                        @can('viewAny', Position::class)
                            <x-slot name="actions">
                                <x-button
                                    :href="route('admin.positions.index', ['tableFilters' => ['department_id' => ['values' => [$department->id]]]])"
                                >
                                    Manage
                                </x-button>
                            </x-slot>
                        @endcan
                    </x-panel.header>

                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                        @forelse ($department->positions as $position)
                            <x-spacing size="row" class="group flex items-center justify-between">
                                <div class="flex items-center gap-x-3">
                                    <x-status :status="$position->status"></x-status>
                                    <div class="truncate font-medium text-gray-900 dark:text-white">
                                        {{ $position->name }}
                                    </div>
                                </div>
                                @can('update', $position)
                                    <x-button
                                        :href="route('admin.positions.edit', $position)"
                                        class="group-hover:visible sm:invisible"
                                        color="neutral"
                                        text
                                    >
                                        <x-icon :name="Icon::Edit" size="sm"></x-icon>
                                    </x-button>
                                @endcan
                            </x-spacing>
                        @empty
                            <x-empty-state.small
                                :icon="Icon::List"
                                title="No positions assigned"
                                message="There aren’t any positions assigned to this department. Assign some positions to this department to populate this list."
                                :link-access="gate()->allows('viewAny', Position::class)"
                                :link="route('admin.positions.index')"
                                label="Assign positions &rarr;"
                            ></x-empty-state.small>
                        @endforelse
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
                                                <x-icon :name="Icon::Edit" size="sm"></x-icon>
                                            </x-button>
                                        @endcan
                                    </div>
                                @empty
                                    <div class="col-span-2">
                                        <x-empty-state.small
                                            :icon="Icon::Characters"
                                            title="No characters assigned"
                                            message="There aren’t any characters assigned to any positions within this department. Assign some characters to positions within this department to populate this list."
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
                    <x-panel.header title="Active users assigned to this department"></x-panel.header>

                    <x-panel>
                        <x-spacing size="md">
                            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
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
                                                <x-icon :name="Icon::Edit" size="sm"></x-icon>
                                            </x-button>
                                        @endcan
                                    </div>
                                @empty
                                    <div class="col-span-2">
                                        <x-empty-state.small
                                            :icon="Icon::Users"
                                            title="No users assigned"
                                            message="There aren’t any active users who have a character assigned to any positions within this department. Assign some characters to positions within this department to populate this list."
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
