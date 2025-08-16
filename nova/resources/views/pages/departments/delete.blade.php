<x-filament.modal-content :$action title="Delete department?">
    <x-text variant="strong">
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name }}</strong>
        department? You won’t be able to recover it.
    </x-text>

    <x-text variant="strong">
        All positions assigned to this department will be removed. Any characters assigned to a position that is removed
        will need to be re-assigned to a new position.
    </x-text>
</x-filament.modal-content>
