@php($count = $records->count())

<x-filament.modal-content :$action>
    <x-slot name="title">Delete {{ $count }} selected {{ str('rank group')->plural($count) }}?</x-slot>

    <x-text variant="strong">Are you sure you want to delete the following rank groups?</x-text>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->name }}</li>
        @endforeach
    </ul>

    <x-text variant="strong">You won’t be able to recover {{ trans_choice('it|them', $count) }}.</x-text>

    <x-text variant="strong">
        This will also delete all ranks within the {{ str('rank group')->plural($count) }} and any characters with
        those ranks will need to have new ranks assigned to them.
    </x-text>
</x-filament.modal-content>
