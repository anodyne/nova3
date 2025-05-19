@use('Nova\Forms\Models\Form')

@pushOnce('styles')
<link rel="preconnect" href="https://fonts.bunny.net" />
<link href="https://fonts.bunny.net/css?family=flow-circular:400" rel="stylesheet" />
@endPushOnce

<x-admin-layout>
    <x-page-header>
        <x-slot name="heading">Design form &mdash; {{ $form->name }}</x-slot>

        <x-slot name="actions">
            @can('viewAny', $form::class)
                <x-button :href="route('admin.forms.index')" plain>&larr; Back</x-button>
            @endcan

            <x-button :href="route('admin.forms.preview', $form)" target="_blank">
                <x-icon name="form-preview" size="sm"></x-icon>
                Preview form
            </x-button>
        </x-slot>
    </x-page-header>

    <div class="my-8 max-w-2xl space-y-8">
        <x-panel.primary
            title="Please note"
            icon="show"
            description="The preview below is not intended to be a high fidelity representation of your form. Once you save your form, you will be able to preview it in the browser."
        ></x-panel.primary>

        @if ($form->updated_at->gt($form->published_at))
            <x-panel.warning
                title="Unpublished changes"
                icon="progress"
                description="Your form field(s) have been saved since you last published them. Nova only shows published form fields to users, so to ensure users are using the form with your latest changes, please publish your form."
            ></x-panel.warning>
        @endif
    </div>

    <livewire:forms-designer :nova-form="$form" />
</x-admin-layout>
