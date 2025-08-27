<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <x-setup::page-heading>Migrate from Nova 2</x-setup::page-heading>

        <x-setup::page-subheading>
            In order to proceed with the migration process, you will need to select the user to receive all of the
            necessary permissions to manage Nova. You will be able to manage access levels for individual users after
            the migration process is complete.
        </x-setup::page-subheading>
    </header>

    <div class="mx-auto max-w-lg space-y-8">
        <x-setup::panel variant="well">
            <x-setup::panel variant="inset">
                <x-spacing size="md">
                    <x-fieldset.fields>
                        <x-select
                            label="Choose system administrator"
                            description="Select your user account and we will assign the necessary admin roles to ensure you can manage Nova"
                            wire:model.live="userId"
                        >
                            <option value="">Pick a user to continue</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </x-select>

                        <x-input.password
                            label="Password"
                            description="Set your new account password"
                            wire:model.live="password"
                        />
                    </x-fieldset.fields>
                </x-spacing>
            </x-setup::panel>
        </x-setup::panel>

        @if (filled($userId) && filled($password))
            <div class="flex items-center justify-center">
                <x-setup::button type="button" wire:click="setAccess">
                    Set access
                    <span aria-hidden="true">→</span>
                </x-setup::button>
            </div>
        @endif
    </div>
</div>
