@extends($meta->template)

@use('Nova\Departments\Models\Position')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Form submission</x-slot>
            <x-slot name="description">
                <x-badge>{{ $submission->form->name }}</x-badge>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', $submission::class)
                    <x-button :href="route('form-submissions.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $submission)
                    <x-button :href="route('form-submissions.edit', $submission)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.field-group>
                    <x-fieldset.field>
                        <x-fieldset.label>Submitted by</x-fieldset.label>
                        <x-text>{{ $submission->owner->name }}</x-text>
                    </x-fieldset.field>

                    <x-fieldset.field>
                        <x-fieldset.label>Submitted on</x-fieldset.label>
                        <x-text>
                            {{ $submission->created_at->format(settings('general')->phpDateFormat()) }}
                        </x-text>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="file-text"></x-icon>
                    <x-fieldset.legend>Responses</x-fieldset.legend>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
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
@endsection
