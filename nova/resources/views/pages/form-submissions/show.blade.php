<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', $submission::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.form-submissions.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan

            <x-slot name="description">
                <x-metadata.group gap="lg">
                    <x-metadata label="Form" :value="$submission->form->name"/>
                    <x-metadata label="Submitted by" :value="$submission->owner->name"/>
                    <x-metadata label="Submitted on" :value="$submission->created_at->formatDate()"/>
                </x-metadata.group>
            </x-slot>
        </x-page-heading>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.group>
                    <livewire:dynamic-form
                        :form="$submission->form"
                        :submission="$submission"
                        :admin="true"
                        :static="true"
                    />
                </x-fieldset.group>
            </x-fieldset>
        </x-form>
    </x-spacing>
</x-admin-layout>
