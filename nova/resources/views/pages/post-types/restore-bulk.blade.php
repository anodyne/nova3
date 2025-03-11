@php
    $originalCount = $records->count();

    $records = $records->filter(fn ($model) => $model->trashed());

    $count = $records->count();
@endphp

<x-filament.modal-content :$action>
    <x-slot name="title">Restore {{ $count }} selected {{ str('post type')->plural($count) }}?</x-slot>

    <p>Are you sure you want to restore the following post types?</p>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->name }}</li>
        @endforeach
    </ul>

    @if ($originalCount !== $count)
        <x-panel.warning>
            <x-slot name="description">
                You selected {{ $originalCount }} {{ str('post type')->plural($originalCount) }}, but only
                {{ $count }} {{ trans_choice('post type is|post types are', $count) }} eligible for restoration. We
                will only restore the {{ $count }} {{ str('post type')->plural($count) }} and ignore the others.
            </x-slot>
        </x-panel.warning>
    @endif
</x-filament.modal-content>
