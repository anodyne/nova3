@extends($meta->template)

@use('Nova\Departments\Models\Department')

@section('content')
    <x-page-header>
        <x-slot name="heading">Departments</x-slot>
        <x-slot name="description">
            Organize character positions into logical groups that you can display on your manifests
        </x-slot>

        <x-slot name="actions">
            @can('create', Department::class)
                <x-button :href="route('admin.departments.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:departments-list />

    <x-tips section="departments"></x-tips>
@endsection
