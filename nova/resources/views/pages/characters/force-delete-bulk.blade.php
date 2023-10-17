@php($count = $records->count())

<x-filament.modal-content icon="check">
    <x-slot name="title">Force delete {{ $count }} selected {{ str('character')->plural($count) }}?</x-slot>

    <p>
        Are you sure you want to force delete the following characters? This action is permanent and cannot be undone.
    </p>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->display_name }}</li>
        @endforeach
    </ul>
</x-filament.modal-content>
