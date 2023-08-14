@php($count = $records->count())

<x-filament.modal-content icon="trash">
    <x-slot name="title">Delete {{ $count }} selected {{ trans_choice('record|records', $count) }}?</x-slot>

    <p>Are you sure you want to delete the following departments?</p>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->name }}</li>
        @endforeach
    </ul>

    <p>You won't be able to recover {{ trans_choice('it|them', $count) }}.</p>

    <p>
        All positions assigned to {{ trans_choice('this department|these departments', $count) }} will be removed. Any
        character(s) assigned to a removed position will need to be re-assigned to another position.
    </p>
</x-filament.modal-content>
