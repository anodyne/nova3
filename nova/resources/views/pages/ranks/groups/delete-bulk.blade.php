@php($count = $records->count())

<x-filament.modal-content icon="trash">
    <x-slot name="title">Delete {{ $count }} selected {{ str('rank group')->plural($count) }}?</x-slot>

    <p>Are you sure you want to delete the following rank groups?</p>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->name }}</li>
        @endforeach
    </ul>

    <p>You won't be able to recover {{ trans_choice('it|them', $count) }}.</p>

    <p>
        This will also delete all ranks within the {{ str('rank group')->plural($count) }} and any characters with
        those ranks will need to have new ranks assigned to them.
    </p>
</x-filament.modal-content>
