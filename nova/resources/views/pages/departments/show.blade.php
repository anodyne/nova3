@extends($meta->template)

@section('content')
    <x-page-header :title="$department->name">
        <x-slot:pretitle>
            <a href="{{ route('departments.index') }}">Departments</a>
        </x-slot:pretitle>

        <x-slot:controls>
            @can('update', $department)
                <x-link :href="route('departments.edit', $department)" color="primary">Edit Department</x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    <x-panel>
        <x-form action="">
            <x-form.section title="Department Info" message="Departments are collections of positions that characters can hold and help to provide some organization for your character manifest.">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $department->name }}</p>
                </x-input.group>

                @if ($department->description)
                    <x-input.group label="Description">
                        <p class="font-semibold">{{ $department->description }}</p>
                    </x-input.group>
                @endif

                <x-input.group label="Status">
                    <x-badge :color="$department->status->color()">{{ $department->status->displayName() }}</x-badge>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Positions">
                <x-slot:message>
                    <p>These are all of the positions currently assigned to this department.</p>

                    @can('viewAny', Nova\Departments\Models\Position::class)
                        <x-link :href="route('positions.index', 'department='.$department->id)" size="xs">
                            Manage department positions
                        </x-link>
                    @endcan
                </x-slot:message>

                <div class="flex flex-col w-full">
                    @foreach ($department->positions as $position)
                        <div class="group flex items-center justify-between py-2 px-4 rounded odd:bg-gray-100 dark:odd:bg-gray-700/50">
                            <div class="flex flex-col sm:flex-row sm:items-center space-x-3">
                                <x-status :status="$position->status"></x-status>
                                <span>{{ $position->name }}</span>
                            </div>
                            @can('update', $position)
                                <x-link :href="route('positions.edit', $position)" size="none" color="gray-text" class="group-hover:visible sm:invisible">
                                    @icon('edit')
                                </x-link>
                            @endcan
                        </div>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.footer>
                <x-link :href="route('departments.index', 'status=active')" color="white">Back</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
