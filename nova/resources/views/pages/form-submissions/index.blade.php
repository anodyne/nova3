@use('Nova\Forms\Models\Form')

<x-admin-layout>
    <x-page-header>
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
</x-admin-layout>
