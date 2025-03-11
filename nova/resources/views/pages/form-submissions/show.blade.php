@use('Nova\Foundation\Helpers\DateHelper')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', $submission::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.form-submissions.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan

            <x-slot name="description">
                <div class="flex items-center gap-x-8">
                    <x-metadata label="Form" :value="$submission->form->name"></x-metadata>
                    <x-metadata label="Submitted by" :value="$submission->owner->name"></x-metadata>
                    <x-metadata
                        label="Submitted on"
                        :value="DateHelper::formatDate($submission->created_at)"
                    ></x-metadata>
                </div>
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.field-group>
                    <livewire:dynamic-form
                        :form="$submission->form"
                        :submission="$submission"
                        :admin="true"
                        :static="true"
                    />
                </x-fieldset.field-group>
            </x-fieldset>
        </x-form>
    </x-spacing>
</x-admin-layout>
