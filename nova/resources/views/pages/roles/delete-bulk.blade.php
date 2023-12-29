@php($count = $records->count())

<x-filament.modal-content icon="trash">
    <x-slot name="title">Delete {{ $count }} selected {{ str('role')->plural($count) }}?</x-slot>

    <x-text>Are you sure you want to delete the following roles?</x-text>

    <ul class="list-inside list-disc text-base/6 sm:text-sm/6">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->display_name }}</li>
        @endforeach
    </ul>

    <x-text>You won’t be able to recover {{ trans_choice('it|them', $count) }}.</x-text>

    <x-text>
        Any user assigned {{ trans_choice('this role|these roles', $count) }} will lose access to what the role
        provides.
    </x-text>
</x-filament.modal-content>
