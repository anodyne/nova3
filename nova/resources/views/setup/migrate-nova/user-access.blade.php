<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Migrate from Nova 2</h1>

        <p class="text-lg/8 text-gray-600">
            Below are all of the available roles in Nova. In order to proceed with the migration process, you will need
            to assign at least 1 user to either the Site Owner or Site Admin role(s).
        </p>
    </header>

    <div class="mx-auto max-w-lg space-y-8">
        <x-panel variant="well">
            <x-panel.header
                title="Choose your user account"
                description="We will assign the necessary admin roles to your user account to ensure you can manage Nova."
            ></x-panel.header>

            <x-panel>
                <x-spacing size="md">
                    <x-fieldset.field name="user" id="user">
                        <x-select wire:model.live="userId">
                            <option value="">Pick a user to continue</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>
                </x-spacing>
            </x-panel>
        </x-panel>

        @if (filled($userId))
            <div class="flex items-center justify-center">
                <x-button.setup type="button" wire:click="setAccess">Set access &rarr;</x-button.setup>
            </div>
        @endif
    </div>
</div>
