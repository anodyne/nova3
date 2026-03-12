<x-filament.modal-content :$action title="Delete page?">
    <x-text>
        Are you sure you want to delete the
        <strong>{{ $record->name }}</strong>
        page? You won’t be able to recover it.
    </x-text>
</x-filament.modal-content>
