<x-filament.modal-content :$action title="Ban user?">
    {{-- format-ignore-start --}}
    <p>
        Are you sure you want to ban
        <strong>{{ $record->name }}</strong>?
    </p>

    <p>This will log them out immediately and prevent them from accessing the site. Their user account will also be deactivated.</p>
    {{-- format-ignore-end --}}
</x-filament.modal-content>
