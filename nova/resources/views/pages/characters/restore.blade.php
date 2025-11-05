<x-filament.modal-content :$action title="Restore character?">
    {{-- format-ignore-start --}}
    <x-text variant="strong">
        Are you sure you want to restore <strong>{{ $record->display_name }}</strong>?
    </x-text>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
