@php($count = $records->count())

<x-filament.modal-content icon="trash">
    <x-slot name="title">Delete {{ $count }} selected {{ str('rank item')->plural($count) }}?</x-slot>

    <p>Are you sure you want to delete the following rank items?</p>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">
                {{ $record->name->name }}
                <em>({{ $record->group->name }})</em>
            </li>
        @endforeach
    </ul>

    <p>You won't be able to recover {{ trans_choice('it|them', $count) }}.</p>

    <p>
        Any character with {{ trans_choice('this rank|these ranks', $count) }} will need to have a new rank assigned to
        them.
    </p>
</x-filament.modal-content>
