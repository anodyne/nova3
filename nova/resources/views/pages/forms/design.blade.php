@use('Nova\Forms\Models\Form')

@pushOnce('styles')
<link rel="preconnect" href="https://fonts.bunny.net" />
<link href="https://fonts.bunny.net/css?family=flow-circular:400" rel="stylesheet" />
@endPushOnce

<x-admin-layout>
    <x-page-header>
        <x-slot name="actions">
            @can('viewAny', $form::class)
                <x-button :href="route('admin.forms.index')" plain>&larr; Back</x-button>
            @endcan

            <x-button :href="route('admin.forms.preview', $form)">
                <x-icon name="form-preview" size="sm"></x-icon>
                Preview form
            </x-button>
        </x-slot>
    </x-page-header>

    <div class="my-8 max-w-2xl">
        <x-panel.primary title="Please note" icon="show">
            The preview below is not intended to be a high fidelity representation of your form. Once you save your
            form, you will be able to preview it in the browser.
        </x-panel.primary>
    </div>

    <livewire:forms-designer :nova-form="$form" />
</x-admin-layout>
