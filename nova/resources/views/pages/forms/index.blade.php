@extends($meta->template)

@use('Nova\Forms\Models\Form')
@use('Nova\Forms\Models\FormSubmission')

@section('content')
    <x-page-header>
        <x-slot name="heading">Forms</x-slot>
        <x-slot name="description">Manage all of Nova’s forms</x-slot>

        <x-slot name="actions">
            @can('viewAny', FormSubmission::class)
                <x-button :href="route('form-submissions.index')" color="neutral">
                    <x-icon name="file-text" size="sm"></x-icon>
                    View submissions
                </x-button>
            @endcan

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
