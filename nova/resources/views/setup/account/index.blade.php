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
        <div class="mx-auto max-w-lg space-y-8">
            <fieldset>
                <div class="isolate -space-y-px rounded-lg shadow-sm">
                    <div
                        class="relative rounded-lg rounded-b-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                    >
                        <label
                            for="user-name"
                            @class([
                                'block text-xs font-medium',
                                'text-gray-900' => ! $errors->has('name'),
                                'text-danger-600' => $errors->has('name'),
                            ])
                        >
                            Name
                        </label>
                        <input
                            type="text"
                            name="user-name"
                            id="user-name"
                            class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            wire:model.defer="name"
                            placeholder="For privacy reasons, we recommend using a nickname or alias"
                        />
                        @error('name')
                            <div class="mt-1 flex items-center gap-1 text-xs text-danger-600">
                                {{-- format-ignore-start --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-danger-400"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                {{-- format-ignore-end --}}

                                <p>{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                    <div
                        class="relative px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                    >
                        <label
                            for="user-email"
                            @class([
                                'block text-xs font-medium',
                                'text-gray-900' => ! $errors->has('email'),
                                'text-danger-600' => $errors->has('email'),
                            ])
                        >
                            Email address
                        </label>
                        <input
                            type="email"
                            name="user-email"
                            id="user-email"
                            class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            wire:model.defer="email"
                            placeholder="me@example.com"
                        />
                        @error('email')
                            <div class="mt-1 flex items-center gap-1 text-xs text-danger-600">
                                {{-- format-ignore-start --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-danger-400"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                {{-- format-ignore-end --}}

                                <p>{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                    <div
                        class="relative rounded-lg rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                    >
                        <label
                            for="user-password"
                            @class([
                                'block text-xs font-medium',
                                'text-gray-900' => ! $errors->has('password'),
                                'text-danger-600' => $errors->has('password'),
                            ])
                        >
                            Password
                        </label>
                        <input
                            type="password"
                            name="user-password"
                            id="user-password"
                            class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            wire:model.defer="password"
                            placeholder="Your password or a passphrase"
                        />
                        @error('password')
                            <div class="mt-1 flex items-center gap-1 text-xs text-danger-600">
                                {{-- format-ignore-start --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-danger-400"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                {{-- format-ignore-end --}}

                                <p>{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>
            </fieldset>

            <div class="flex items-center justify-between">
                <x-button.setup type="button" wire:click="createUserAccount" size="sm">Create account</x-button.setup>
            </div>
        </div>
    @endif

    @if ($shouldShowSuccessTable)
        <div class="mx-auto max-w-lg space-y-8">
            <x-panel class="overflow-hidden">
                <div class="divide-y divide-gray-200">
                    @include('setup.account._user-created')
                    @include('setup.account._roles-assigned')
                    @include('setup.account._signin')
                </div>
            </x-panel>
        </div>

        <div class="flex items-center justify-center">
            <x-button.setup :href="route('dashboard')">Get started with Nova &rarr;</x-button.setup>
        </div>
    @endif
</div>

@pushOnce('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>
@endPushOnce
