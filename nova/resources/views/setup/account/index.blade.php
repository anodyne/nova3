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
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Setup your account</h1>

        <p class="text-lg/8 text-gray-600">
            The last step is to setup your account. Once your account is created, you’ll be able to sign in to Nova,
            create your character(s), and configure Nova.
        </p>
    </header>

    @if ($shouldShowForm)
        <div class="mx-auto max-w-lg space-y-12">
            <x-fieldset>
                <x-fieldset.field-group>
                    <x-fieldset.field
                        label="Name"
                        description="For privacy reasons, we recommend using a nickname or alias rather than your real name"
                        id="name"
                        name="name"
                        :error="$errors->first('name')"
                    >
                        <x-input.text wire:model="name"></x-input.text>
                    </x-fieldset.field>

                    <x-fieldset.field label="Email address" id="email" name="email" :error="$errors->first('email')">
                        <x-input.email wire:model="email" placeholder="me@example.com"></x-input.email>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Password"
                        id="password"
                        name="password"
                        :error="$errors->first('password')"
                    >
                        <x-input.password
                            wire:model="password"
                            placeholder="Your password or a passphrase"
                        ></x-input.password>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <div class="flex items-center justify-between">
                <x-button.setup type="button" wire:click="createUserAccount" size="sm">Create account</x-button.setup>
            </div>
        </div>
    @endif

    @if ($shouldShowSuccessTable)
        <div class="mx-auto max-w-lg space-y-8">
            <x-panel well>
                <x-spacing size="2xs">
                    <x-panel class="divide-y divide-gray-950/5">
                        @include('setup.account._user-created')
                        @include('setup.account._roles-assigned')
                        @include('setup.account._signin')
                    </x-panel>
                </x-spacing>
            </x-panel>
        </div>

        <div class="flex items-center justify-center">
            <x-button.setup :href="route('admin.dashboard')">Get started with Nova &rarr;</x-button.setup>
        </div>
    @endif
</div>

@pushOnce('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
@endPushOnce
