<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Migrate from Nova 2</h1>

        <p class="text-pretty text-lg/8 text-gray-600">
            In order to proceed with the migration process, you will need to select the user to receive all of the
            necessary permissions to manage Nova. You will be able to manage access levels for individual users after
            the migration process is complete.
        </p>
    </header>

    <div class="mx-auto max-w-lg space-y-8">
        <x-panel variant="well">
            <x-panel variant="inset">
                <x-spacing size="md">
                    <x-fieldset.field-group>
                        <x-fieldset.field
                            label="Choose system administrator"
                            description="Select your user account and we will assign the necessary admin roles to ensure you can manage Nova"
                            name="user"
                            id="user"
                        >
                            <x-select wire:model.live="userId">
                                <option value="">Pick a user to continue</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </x-select>
                        </x-fieldset.field>

                        <x-fieldset.field
                            label="Password"
                            description="Set your new account password"
                            name="password"
                            id="password"
                        >
                            <x-input.password wire:model.live="password"></x-input.password>
                        </x-fieldset.field>
                    </x-fieldset.field-group>
                </x-spacing>
            </x-panel>
        </x-panel>

        @if (filled($userId) && filled($password))
            <div class="flex items-center justify-center">
                <x-button.setup type="button" wire:click="setAccess">Set access &rarr;</x-button.setup>
            </div>
        @endif
    </div>
</div>
