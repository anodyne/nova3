@php($count = $records->count())

<x-filament.modal-content icon="trash">
    <x-slot name="title">Delete {{ $count }} selected {{ str('post type')->plural($count) }}?</x-slot>

    <p>Are you sure you want to delete the following post types?</p>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->name }}</li>
        @endforeach
    </ul>

    <p>
        Users will no longer be able to create story posts with
        {{ trans_choice('this post type|these post types', $count) }}.
    </p>
</x-filament.modal-content>
