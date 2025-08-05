@use('Nova\Forms\Models\Form')
@use('Nova\Forms\Models\FormSubmission')

<x-admin-layout>
    <x-page-header>
        <x-slot name="actions">
            @can('viewAny', FormSubmission::class)
                <x-button :href="route('admin.form-submissions.index')" color="neutral">
                    <x-icon :name="Icon::FileText" size="sm"></x-icon>
                    View submissions
                </x-button>
            @endcan

            @can('create', Form::class)
                <x-button :href="route('admin.forms.create')" color="primary">
                    <x-icon :name="Icon::Plus" size="sm"></x-icon>
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-header>

    <livewire:forms-list />

    <x-tips section="forms" />
</x-admin-layout>
