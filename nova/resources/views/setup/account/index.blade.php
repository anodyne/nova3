<div
    class="mx-auto max-w-7xl space-y-16"
    x-data="{
        celebrate() {
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 },
            })
        },
    }"
    x-on:confetti.window="celebrate()"
>
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <x-setup::page-heading>Setup your account</x-setup::page-heading>

        <x-setup::page-subheading>
            The last step is to setup your account. Once your account is created, you’ll be able to sign in to Nova,
            create your character(s), and configure Nova.
        </x-setup::page-subheading>
    </header>

    @if ($shouldShowForm)
        <div class="mx-auto max-w-lg space-y-12">
            <x-fieldset>
                <x-fieldset.fields>
                    <x-input
                        label="Name"
                        description="For privacy reasons, we recommend using a nickname or alias rather than your real name"
                        wire:model="name"
                    />

                    <x-input.email label="Email address" wire:model="email" placeholder="me@example.com" />

                    <x-input.password
                        label="Password"
                        wire:model="password"
                        placeholder="Your password or a passphrase"
                    />
                </x-fieldset.fields>
            </x-fieldset>

            <div class="flex items-center justify-between">
                <x-setup::button type="button" wire:click="createUserAccount" size="sm">Create account</x-setup::button>
            </div>
        </div>
    @endif

    @if ($shouldShowSuccessTable)
        <div class="mx-auto max-w-lg space-y-8">
            <x-setup::panel variant="well">
                <x-setup::panel class="grid grid-cols-[auto_1fr_auto] divide-y divide-gray-950/5" variant="inset">
                    @include('setup.account._user-created')
                    @include('setup.account._roles-assigned')
                    @include('setup.account._send-telemetry')
                    @include('setup.account._signin')
                </x-setup::panel>
            </x-setup::panel>
        </div>

        <div class="flex items-center justify-center">
            <x-setup::button :href="route('admin.dashboard')">
                Get started with Nova
                <span aria-hidden="true">→</span>
            </x-setup::button>
        </div>
    @endif
</div>

@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
@endPushOnce
