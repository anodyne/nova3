@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Activity log detail">
            <x-slot name="actions">
                @can('viewAny', Spatie\Activitylog\Models\Activity::class)
                    <x-button.text :href="route('activity-log.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form action="">
            <x-form.section
                title="Details"
                message="Departments are collections of positions that characters can hold and help to provide some organization for your character manifest."
            >
                <x-input.group label="Type">
                    <x-badge>{{ ucfirst($activity->log_name) }}</x-badge>
                </x-input.group>

                <x-input.group label="Event">
                    <x-badge>{{ ucfirst($activity->event) }}</x-badge>
                </x-input.group>

                <x-input.group label="User">
                    <p>{{ $activity->causer->name }}</p>
                </x-input.group>

                <x-input.group label="Subject">
                    <p>{{ $activity->subject_type }}</p>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Properties"
                message="Departments are collections of positions that characters can hold and help to provide some organization for your character manifest."
            >
                <x-input.group label="Type">
                    <p>{{ $activity->properties }}</p>
                </x-input.group>
            </x-form.section>
        </x-form>
    </x-panel>
@endsection
