@php
    $originalCount = $records->count();

    $records = $records->filter(fn ($model) => $model->status->equals(Nova\Characters\Models\States\Status\Inactive::class));

    $count = $records->count();
@endphp

<x-filament.modal-content icon="check">
    <x-slot name="title">Activate {{ $count }} selected {{ str('character')->plural($count) }}?</x-slot>

    <p>Are you sure you want to activate the following characters?</p>

    <ul class="list-inside list-disc">
        @foreach ($records as $record)
            <li class="px-2 py-1">{{ $record->display_name }}</li>
        @endforeach
    </ul>

    @if ($originalCount !== $count)
        <x-panel.warning>
            You selected {{ $originalCount }} {{ str('character')->plural($originalCount) }}, but only {{ $count }}
            {{ trans_choice('character is|characters are', $count) }} eligible for activation. We will only activate
            the {{ $count }} {{ str('character')->plural($count) }} and ignore the others. If you would like to
            deactivate any active characters, you can use the Deactivate bulk action.
        </x-panel.warning>
    @endif
</x-filament.modal-content>
