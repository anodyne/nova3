@php
    use Nova\Setup\Enums\NovaInstallStatus;
@endphp

<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Install Nova</h1>

        <p class="text-lg/8 text-gray-600">Tell us a little bit about your game before installing Nova.</p>
    </header>

    @if ($shouldShowForm)
        <div class="mx-auto max-w-lg space-y-8">
            @if ($errorMessage)
                <x-panel.danger title="Error installing Nova" icon="tabler-alert-circle">
                    {{ $errorMessage }}
                </x-panel.danger>
            @endif

            <fieldset>
                <div class="isolate -space-y-px rounded-lg shadow-sm">
                    <div
                        class="relative rounded-lg rounded-b-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                    >
                        <label
                            for="game-name"
                            @class([
                                'block text-xs font-medium',
                                'text-gray-900' => ! $errors->has('name'),
                                'text-danger-600' => $errors->has('name'),
                            ])
                        >
                            Name of your game
                        </label>
                        <input
                            type="text"
                            name="game-name"
                            id="game-name"
                            class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            wire:model.defer="name"
                            placeholder="What's the name of your game?"
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
                        class="relative rounded-lg rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600"
                    >
                        <label
                            for="game-genre"
                            @class([
                                'block text-xs font-medium',
                                'text-gray-900' => ! $errors->has('genre'),
                                'text-danger-600' => $errors->has('genre'),
                            ])
                        >
                            Genre
                        </label>
                        <input
                            type="text"
                            name="game-genre"
                            id="game-genre"
                            class="mt-1 block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                            wire:model.defer="genre"
                        />
                        @error('genre')
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

            @env('local')
                <x-switch-toggle wire:model="shouldSeed" color="gray">Seed the database with test data</x-switch-toggle>
            @endenv

            <x-button.setup type="button" wire:click="install" size="sm">
                <div class="flex items-center gap-3">
                    <div>Start install</div>
                    <x-icon.loader
                        class="h-5 w-5 animate-spin text-white"
                        wire:loading
                        wire:target="install"
                    ></x-icon.loader>
                </div>
            </x-button.setup>
        </div>
    @endif

    @if ($shouldShowSuccess)
        <div class="mx-auto max-w-lg space-y-8">
            <x-panel class="overflow-hidden">
                <div class="divide-y divide-gray-200">
                    @include('setup.install-nova._check-installed')
                    @include('setup.install-nova._check-genre')
                    @include('setup.install-nova._check-update-settings')
                </div>
            </x-panel>
        </div>

        <div class="flex items-center justify-center gap-8">
            {{--
                <x-button.setup href="{{ url('setup/migrate') }}" leading="tabler-arrow-forward-up-double">
                Migrate your Nova 2 data
                </x-button.setup>
                
                <span class="text-sm font-semibold uppercase text-gray-500">or</span>
            --}}

            <x-button.setup href="{{ url('setup/setup-account') }}" leading="tabler-circle-arrow-right">
                Continue as a fresh install
            </x-button.setup>
        </div>
    @endif
</div>
