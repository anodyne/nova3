@php($count = $records->count())

<x-filament.modal-content :$action>
    <x-slot name="title">Delete {{ $count }} selected {{ str('position')->plural($count) }}?</x-slot>

    <x-text variant="strong">Are you sure you want to delete the following positions?</x-text>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">
                {{ $record->name }}
                <em>({{ $record->department?->name ?? 'No department' }})</em>
            </li>
        @endforeach
    </ul>

    <x-text variant="strong">You won’t be able to recover {{ trans_choice('it|them', $count) }}.</x-text>

    <x-text variant="strong">
        Any character(s) assigned to a removed position will need to be re-assigned to another position.
    </x-text>
</x-filament.modal-content>
