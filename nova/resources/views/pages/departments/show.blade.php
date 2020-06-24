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
        <x-form.section title="Department Info">
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

        <x-form.section title="Positions">
            Coming soon...
        </x-form.section>

        <x-form.footer>
            <a href="{{ route('departments.index') }}" class="button">Back</a>
        </x-form.footer>
    </x-panel>
@endsection
