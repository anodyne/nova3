@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$department->name">
            <x-slot:actions>
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

        <x-form action="">
            <x-form.section
                title="Department Info"
                message="Departments are collections of positions that characters can hold and help to provide some organization for your character manifest."
            >
                <x-input.group label="Name">
                    <p>{{ $department->name }}</p>
                </x-input.group>

                @if (filled($department->description))
                    <x-input.group label="Description">
                        <p>{{ $department->description }}</p>
                    </x-input.group>
                @endif

                <x-input.group label="Status">
                    <x-badge :color="$department->status->color()">{{ $department->status->getLabel() }}</x-badge>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Positions">
                <x-slot name="message">
                    <p>These are all of the positions currently assigned to this department.</p>

                    @can('viewAny', Nova\Departments\Models\Position::class)
                        <x-button.filled
                            :href="route('positions.index', ['tableFilters' => ['department_id' => ['values' => [$department->id]]]])"
                            color="gray"
                        >
                            Manage department positions
                        </x-button.filled>
                    @endcan
                </x-slot>

                <div class="flex w-full flex-col">
                    @foreach ($department->positions as $position)
                        <div
                            class="group flex items-center justify-between rounded-md px-4 py-2 odd:bg-gray-100 dark:odd:bg-gray-700/50"
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
                    @endforeach
                </div>
            </x-form.section>
        </x-form>
    </x-panel>
@endsection
