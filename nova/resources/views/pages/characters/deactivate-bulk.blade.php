@php
    $originalCount = $records->count();

    $records = $records->filter(fn ($model) => $model->is_active);

    $count = $records->count();
@endphp

<x-filament.modal-content :$action>
    <x-slot name="title">Deactivate {{ $count }} selected {{ str('character')->plural($count) }}?</x-slot>

    <x-text variant="strong">Are you sure you want to deactivate the following characters?</x-text>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->display_name }}</li>
        @endforeach
    </ul>

    @if ($originalCount !== $count)
        <x-callout.warning>
            You selected {{ $originalCount }} {{ str('character')->plural($originalCount) }}, but only {{ $count }}
            {{ trans_choice('character is|characters are', $count) }} eligible for deactivation. We will only
            deactivate the {{ $count }} {{ str('character')->plural($count) }} and ignore the others. If you would
            like to activate any inactive characters, you can use the Activate bulk action.
        </x-callout.warning>
    @endif
</x-filament.modal-content>
