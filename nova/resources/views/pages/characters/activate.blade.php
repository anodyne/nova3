<x-filament.modal-content :$action title="Activate character?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to activate <strong class="font-semibold">{{ $record->display_name }}</strong>?
    </p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
