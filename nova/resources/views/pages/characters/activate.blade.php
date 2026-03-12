<x-filament.modal-content :$action title="Activate character?">
    {{-- format-ignore-start --}}
    <x-text variant="strong">
        Are you sure you want to activate <strong>{{ $record->display_name }}</strong>?
    </x-text>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
