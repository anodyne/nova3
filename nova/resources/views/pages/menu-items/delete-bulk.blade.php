@php($count = $records->count())

<x-filament.modal-content icon="trash">
    <x-slot name="title">Delete {{ $count }} selected {{ str('menu item')->plural($count) }}?</x-slot>

    <p>Are you sure you want to delete the following menu items?</p>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->label }}</li>
        @endforeach
    </ul>

    <p>You won’t be able to recover {{ trans_choice('it|them', $count) }}.</p>
</x-filament.modal-content>
