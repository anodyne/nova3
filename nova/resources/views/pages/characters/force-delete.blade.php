<x-filament.modal-content :$action title="Force delete character?">
    {{-- format-ignore-start --}}
    <x-text variant="strong">
        Are you sure you want to force delete
        <strong>{{ $record->display_name }}</strong>?
        This action is permanent and cannot be undone.
    </x-text>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
