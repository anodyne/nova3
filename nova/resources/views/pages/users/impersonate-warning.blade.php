<x-filament.modal-content icon="spy" title="Impersonate user">
    {{-- format-ignore-start --}}
    <p>You are about to impersonate the account belonging to <strong class="font-semibold">{{ $record->name }}</strong> (<em>{{ $record->email }}</em>).</p>
    {{-- format-ignore-end --}}

    <p>
        You will be able to log in as them, see and do everything they can. Everything you do while impersonating this
        user will be logged. To return to your own account, click the X at the top of the screen.
    </p>

    <p>Like Uncle Ben said, with great power comes great responsibility. Use this power wisely.</p>
</x-filament.modal-content>
