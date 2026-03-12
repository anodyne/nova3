@use('Nova\Forms\Models\Form')

<x-admin-layout>
    <x-page-heading>
        <x-slot name="actions">
            @can('viewAny', Form::class)
                <x-button :href="route('admin.forms.index')">
                    <x-icon :name="Tabler::Forms" size="sm" />
                    Manage forms
                </x-button>
            @endcan

            <x-button :href="route('admin.form-submissions.create')" variant="primary">
                <x-icon :name="Tabler::Edit" size="sm" />
                Submit a form
            </x-button>
        </x-slot>
    </x-page-heading>

    <livewire:forms-submissions-list />

    <x-tips section="forms" />
</x-admin-layout>
