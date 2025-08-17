@php($count = $records->count())

<x-filament.modal-content :$action>
    <x-slot name="title">Delete {{ $count }} selected {{ str('rank name')->plural($count) }}?</x-slot>

    <x-text variant="strong">Are you sure you want to delete the following rank names?</x-text>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->name }}</li>
        @endforeach
    </ul>

    <x-text variant="strong">You won’t be able to recover {{ trans_choice('it|them', $count) }}.</x-text>

    <x-text variant="strong">
        This will also delete all ranks associated with the {{ str('rank name')->plural($count) }} and any characters
        with those ranks will need to have new ranks assigned to them.
    </x-text>
</x-filament.modal-content>
