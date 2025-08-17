@php($count = $records->loadMissing('group')->count())

<x-filament.modal-content :$action>
    <x-slot name="title">Delete {{ $count }} selected {{ str('rank item')->plural($count) }}?</x-slot>

    <x-text variant="strong">Are you sure you want to delete the following rank items?</x-text>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">
                {{ $record->name->name }}
                <em>({{ $record->group->name }})</em>
            </li>
        @endforeach
    </ul>

    <x-text variant="strong">You won’t be able to recover {{ trans_choice('it|them', $count) }}.</x-text>

    <x-text variant="strong">
        Any character with {{ trans_choice('this rank|these ranks', $count) }} will need to have a new rank assigned to
        them.
    </x-text>
</x-filament.modal-content>
