@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$department->name">
        <x-slot name="pretitle">
            <a href="{{ route('departments.index') }}">Departments</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $department)
                <a href="{{ route('departments.edit', $department) }}" class="button button-primary">Edit Department</a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form.section title="Department Info" message="Departments are collections of positions that characters can hold and help to provide some organization for your character manifest.">
            <x-input.group label="Name">
                <p class="font-semibold">{{ $department->name }}</p>
            </x-input.group>

            <x-input.group label="Description">
                <p class="font-semibold">{{ $department->description }}</p>
            </x-input.group>

            <x-input.group label="Status">
                <p class="font-semibold">{{ $department->active ? 'Active' : 'Inactive' }}</p>
            </x-input.group>
        </x-form.section>

        <x-form.section title="Positions" message="These are all of the positions currently assigned to this department.">
            <div class="flex flex-col w-full">
                @foreach ($department->positions as $position)
                    <div class="group flex items-center justify-between py-2 px-4 rounded even:bg-gray-100">
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
            <a href="{{ route('departments.index') }}" class="button">Back</a>
        </x-form.footer>
    </x-panel>
@endsection