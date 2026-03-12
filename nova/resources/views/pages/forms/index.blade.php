@use('Nova\Forms\Models\Form')
@use('Nova\Forms\Models\FormSubmission')

<x-admin-layout>
    <x-page-heading>
        <x-slot name="actions">
            @can('viewAny', FormSubmission::class)
                <x-button :href="route('admin.form-submissions.index')">
                    <x-icon :name="Tabler::FileText" size="sm" />
                    View submissions
                </x-button>
            @endcan

            @can('create', Form::class)
                <x-button :href="route('admin.forms.create')" variant="primary">
                    <x-icon :name="Tabler::Plus" size="sm" />
                    Add
                </x-button>
            @endcan
        </x-slot>
    </x-page-heading>

    <livewire:forms-list />

    <x-tips section="forms" />
</x-admin-layout>
