@php($count = $records->count())

<x-filament.modal-content icon="trash">
    <x-slot name="title">Delete {{ $count }} selected {{ str('role')->plural($count) }}?</x-slot>

    <p>Are you sure you want to delete the following roles?</p>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->display_name }}</li>
        @endforeach
    </ul>

    <p>You won't be able to recover {{ trans_choice('it|them', $count) }}.</p>

    <p>
        Any user assigned {{ trans_choice('this role|these roles', $count) }} will lose access to what the role
        provides.
    </p>
</x-filament.modal-content>
