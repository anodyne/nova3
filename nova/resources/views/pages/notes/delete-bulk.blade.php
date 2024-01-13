@php($count = $records->count())

<x-filament.modal-content icon="trash">
    <x-slot name="title">Delete {{ $count }} selected {{ str('note')->plural($count) }}?</x-slot>

    <x-text>Are you sure you want to delete the following notes?</x-text>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->title }}</li>
        @endforeach
    </ul>

    <x-text>You won’t be able to recover {{ trans_choice('it|them', $count) }}.</x-text>
</x-filament.modal-content>
