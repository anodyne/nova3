@php
    $originalCount = $records->count();

    $records = $records->filter(fn ($model) => ! $model->trashed());

    $count = $records->count();
@endphp

<x-filament.modal-content icon="trash">
    <x-slot name="title">Delete {{ $count }} selected {{ str('post type')->plural($count) }}?</x-slot>

    <p>Are you sure you want to delete the following post types?</p>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->name }}</li>
        @endforeach
    </ul>

    <p>
        Posts assigned to {{ trans_choice('this post type|these post types', $count) }} will still be able to be
        viewed, but users will no longer be able to create story posts with {{ trans_choice('it|them', $count) }}. If
        you would like to move posts from {{ trans_choice('this|these', $count) }}
        {{ str('post type')->plural($count) }} to a new one, you will need to delete
        {{ trans_choice('it|them', $count) }} individually.
    </p>

    @if ($originalCount !== $count)
        <x-panel.warning>
            You selected {{ $originalCount }} {{ str('post type')->plural($originalCount) }}, but only {{ $count }}
            {{ trans_choice('post type is|post types are', $count) }} eligible for deletion. We will only delete the
            {{ $count }} {{ str('post type')->plural($count) }} and ignore the others.
        </x-panel.warning>
    @endif
</x-filament.modal-content>
