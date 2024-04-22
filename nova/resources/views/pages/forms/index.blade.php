@extends($meta->template)

@use('Nova\Forms\Models\Form')

@section('content')
    <x-page-header>
        <x-slot name="heading">Forms</x-slot>
        <x-slot name="description">Manage all of Nova’s forms</x-slot>

        <x-slot name="actions">
            @can('create', Form::class)
                <x-button :href="route('forms.create')" color="primary">
                    <x-icon name="add" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:forms-list />

    <x-tips section="forms" />
@endsection
