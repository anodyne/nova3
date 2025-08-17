<x-filament.modal-content :$action title="Delete rank item?">
    <x-text variant="strong">
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name?->name }}</strong>
        rank item from the
        <em>{{ $record->group?->name }}</em>
        rank group? You won’t be able to recover it.
    </x-text>

    @if ($record->characters->count() > 0)
        <x-text variant="strong">Any character with this rank will need to have a new rank assigned to them.</x-text>
    @endif
</x-filament.modal-content>
