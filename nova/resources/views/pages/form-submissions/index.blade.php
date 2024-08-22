@extends($meta->template)

@use('Nova\Forms\Models\Form')

@section('content')
    <x-page-header>
        <x-slot name="heading">Form submissions</x-slot>
        <x-slot name="description">Manage all of Nova’s form submissions</x-slot>

        <x-slot name="actions">
            @can('viewAny', Form::class)
                <x-button :href="route('admin.forms.index')" color="neutral">
                    <x-icon name="form" size="sm"></x-icon>
                    Manage forms
                </x-button>
            @endcan

            <x-button :href="route('admin.form-submissions.create')" color="primary">
                <x-icon name="write" size="sm"></x-icon>
                Submit a form
            </x-button>
        </x-slot>
    </x-page-header>

    <livewire:forms-submissions-list />

    <x-tips section="forms" />
@endsection
