<x-admin-layout>
    <x-panel>
        <x-panel.header :title="$form->name" />

        <x-form action="" :space="false">
            <x-form.section title="Form Info" message="Ad in nostrud nostrud laboris in qui aliquip velit.">
                <x-fieldset.field label="Name">
                    <p class="font-semibold">{{ $form->name }}</p>
                </x-fieldset.field>

                <x-fieldset.field label="Key">
                    <p class="font-semibold">{{ $form->key }}</p>
                </x-fieldset.field>

                @if ($form->description)
                    <x-fieldset.field label="Description">
                        <p class="font-semibold">{{ $form->description }}</p>
                    </x-fieldset.field>
                @endif
            </x-form.section>

            <x-fieldset.controls class="mt-4 md:mt-8">
                @can('update', $form)
                    <x-button :href="route('admin.forms.edit', $form)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                    <x-button :href="route('admin.forms.design', $form)" color="neutral">
                        <x-icon name="tools" size="sm"></x-icon>
                        Design
                    </x-button>
                @endcan

                @can('viewAny', $form::class)
                    <x-button :href="route('admin.forms.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-fieldset.controls>
        </x-form>
    </x-panel>
</x-admin-layout>
