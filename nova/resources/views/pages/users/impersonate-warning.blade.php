{{-- format-ignore-start --}}
<div class="flex flex-col gap-6">
    <div class="flex items-center gap-3">
        <x-icon name="spy" size="lg" class="text-gray-500"></x-icon>
        <x-h2>Impersonate user</x-h2>
    </div>
    <div class="flex flex-col gap-4">
        <p>You are about to impersonate the account belonging to <strong class="font-semibold">{{ $record->name }}</strong> (<em>{{ $record->email }}</em>).</p>

        <p>You will be able to log in as them, see and do everything they can. Everything you do while impersonating this user will be logged. To return to your own account, click the X at the top of the screen.</p>

        <p>Like Uncle Ben said, with great power comes great responsibility. Use this power wisely.</p>
    </div>
</div>
{{-- format-ignore-end --}}
