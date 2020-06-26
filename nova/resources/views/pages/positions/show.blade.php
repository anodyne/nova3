@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$position->name">
        <x-slot name="pretitle">
            <a href="{{ route('departments.index') }}">Departments</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $position)
                <a href="{{ route('positions.edit', $position) }}" class="button button-primary">Edit Position</a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form.section title="Position Info">
            <x-input.group label="Name">
                <p class="font-semibold">{{ $position->name }}</p>
            </x-input.group>

            <x-input.group label="Description">
                <p class="font-semibold">{{ $position->description }}</p>
            </x-input.group>

            <x-input.group label="Department">
                <p class="font-semibold">{{ $position->department->name }}</p>
            </x-input.group>

            <x-input.group label="Available Slots">
                <p class="font-semibold">{{ $position->available }}</p>
            </x-input.group>

            <x-input.group label="Status">
                <p class="font-semibold">{{ $position->active ? 'Active' : 'Inactive' }}</p>
            </x-input.group>
        </x-form.section>

        <x-form.section title="Assigned Characters">
            Coming soon...
        </x-form.section>

        <x-form.footer>
            <a href="{{ route('positions.index', $position->department) }}" class="button">Back</a>
        </x-form.footer>
    </x-panel>
@endsection
