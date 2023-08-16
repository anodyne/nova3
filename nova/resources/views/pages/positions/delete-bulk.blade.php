@php($count = $records->count())

<x-filament.modal-content icon="trash">
    <x-slot name="title">Delete {{ $count }} selected {{ str('position')->plural($count) }}?</x-slot>

    <p>Are you sure you want to delete the following positions?</p>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">
                {{ $record->name }}
                <em>({{ $record->department?->name ?? 'No department' }})</em>
            </li>
        @endforeach
    </ul>

    <p>You won't be able to recover {{ trans_choice('it|them', $count) }}.</p>

    <p>Any character(s) assigned to a removed position will need to be re-assigned to another position.</p>
</x-filament.modal-content>
