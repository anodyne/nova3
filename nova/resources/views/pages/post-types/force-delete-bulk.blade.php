@php($count = $records->count())

<x-filament.modal-content :$action>
    <x-slot name="title">Force delete {{ $count }} selected {{ str('post type')->plural($count) }}?</x-slot>

    <x-text variant="strong">
        Are you sure you want to force delete the following post types? This action is permanent and cannot be undone.
    </x-text>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->name }}</li>
        @endforeach
    </ul>

    <x-text variant="strong">
        If you would like to move posts from {{ trans_choice('this|these', $count) }}
        {{ str('post type')->plural($count) }} to a new one, you will need to force delete
        {{ trans_choice('it|them', $count) }} individually.
    </x-text>
</x-filament.modal-content>
