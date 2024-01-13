@php($count = $records->count())

<x-filament.modal-content icon="key">
    <x-slot name="title">Force password reset for {{ $count }} selected {{ str('user')->plural($count) }}?</x-slot>

    <x-text>Are you sure you want to force a password reset for the following users?</x-text>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->name }}</li>
        @endforeach
    </ul>
</x-filament.modal-content>
