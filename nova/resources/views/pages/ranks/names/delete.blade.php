<x-filament.modal-content :$action title="Delete rank name?">
    <x-text variant="strong">
        Are you sure you want to delete the
        <strong class="font-semibold">{{ $record->name }}</strong>
        rank name? You won’t be able to recover it.
    </x-text>

    @if ($record->ranks->count() > 0)
        <x-text variant="strong">
            This will also delete all ranks associated with the rank name and any characters with those ranks will need
            to have new ranks assigned to them.
        </x-text>
    @endif
</x-filament.modal-content>
