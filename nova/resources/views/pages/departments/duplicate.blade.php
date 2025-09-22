<x-filament.modal-content :$action title="Duplicate department?">
    <x-text variant="strong">
        Are you sure you want to duplicate the
        <strong>{{ $record->name }}</strong>
        department and all of its positions?
    </x-text>
</x-filament.modal-content>
