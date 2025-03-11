<x-filament.modal-content :$action title="Delete character?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to delete <strong class="font-semibold">{{ $record->display_name }}</strong>?
    </p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
