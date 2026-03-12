<x-filament.modal-content :$action title="Delete ban?">
    {{-- format-ignore-start --}}
    <x-text variant="strong">
        Are you sure you want to delete the ban for
        <strong>{{ $record->bannable?->name ?? $record->ip }}</strong>?
    </x-text>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
