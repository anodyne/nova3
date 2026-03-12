<x-filament.modal-content :$action title="Impersonate user">
    {{-- format-ignore-start --}}
    <x-text variant="strong">You are about to impersonate the account belonging to <strong>{{ $record->name }}</strong> (<em>{{ $record->email }}</em>).</x-text>
    {{-- format-ignore-end --}}

    <x-text variant="strong">
        You will be able to log in as them, see and do everything they can. Everything you do while impersonating this
        user will be logged. To return to your own account, click the X at the top of the screen.
    </x-text>

    <x-text variant="strong">
        Like Uncle Ben said, with great power comes great responsibility. Use this power wisely.
    </x-text>
</x-filament.modal-content>
