<x-filament.modal-content icon="trash" title="Force delete character?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to force delete <strong class="font-semibold">{{ $record->display_name }}</strong>? This action cannot be undone.
    </p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
