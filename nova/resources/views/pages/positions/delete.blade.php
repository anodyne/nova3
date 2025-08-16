<x-filament.modal-content :$action title="Delete position?">
    <x-text variant="strong">
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name }}</strong>
        position from the {{ $record->department?->name }} department? You won’t be able to recover it.
    </x-text>

    <x-text variant="strong">
        Any characters assigned to this position will need to be re-assigned to another position.
    </x-text>
</x-filament.modal-content>
