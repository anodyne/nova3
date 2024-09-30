@extends($meta->template)

@use('Spatie\Activitylog\Models\Activity')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                @can('viewAny', Activity::class)
                    <x-button :href="route('admin.activity-log.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-fieldset>
                <x-fieldset.field-group>
                    <x-fieldset.field label="Type">
                        <x-badge size="md">{{ ucfirst($activity->log_name) }}</x-badge>
                    </x-fieldset.field>

                    <x-fieldset.field label="Event">
                        <x-badge size="md">{{ ucfirst($activity->event) }}</x-badge>
                    </x-fieldset.field>

                    <x-fieldset.field label="User">
                        <p>{{ $activity->causer->name }}</p>
                    </x-fieldset.field>

                    <x-fieldset.field label="Subject">
                        <p>{{ $activity->subject_type }}</p>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Properties</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel>
                            <x-spacing size="md">
                                <x-text.code size="sm">
                                    {{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}
                                </x-text.code>
                            </x-spacing>
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </x-fieldset>
        </x-form>
    </x-spacing>
@endsection
