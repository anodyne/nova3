@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$department->name">
        <x-slot name="pretitle">
            <a href="{{ route('departments.index') }}">Departments</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $department)
                <x-link :href="route('departments.edit', $department)" color="blue">Edit Department</x-link>
            @endcan
        </x-slot>
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
                    @if ($department->active)
                        <x-badge color="green">Active</x-badge>
                    @else
                        <x-badge color="gray">Inactive</x-badge>
                    @endif
                </x-input.group>
            </x-form.section>

            <x-form.section title="Positions" message="These are all of the positions currently assigned to this department.">
                <div class="flex flex-col w-full">
                    @foreach ($department->positions as $position)
                        <div class="group flex items-center justify-between py-2 px-4 rounded odd:bg-gray-100">
                            <div class="flex flex-col | sm:flex-row sm:items-center">
                                {{ $position->name }}
                            </div>
                            @can('update', $position)
                                <a href="{{ route('positions.edit', $position) }}" class="text-gray-500 transition ease-in-out duration-150 hover:text-gray-700 group-hover:visible | sm:invisible">
                                    @icon('edit')
                                </a>
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
