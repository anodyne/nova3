@php($count = $records->count())

<x-filament.modal-content :$action>
    <x-slot name="title">Delete {{ $count }} selected {{ str('ban')->plural($count) }}?</x-slot>

    <x-text>Are you sure you want to delete the following bans?</x-text>

    <ul class="list-inside list-disc text-base/6 sm:text-sm/6">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->bannable?->name ?? $record->ip }}</li>
        @endforeach
    </ul>

    <x-text>You won’t be able to recover {{ trans_choice('it|them', $count) }}.</x-text>
</x-filament.modal-content>
