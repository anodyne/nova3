@php
    use Nova\Setup\Enums\NovaInstallStatus;
@endphp

<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Install Nova</h1>

        <p class="text-lg/8 text-gray-600">Tell us a little bit about your game before installing Nova.</p>
    </header>

    @if ($shouldShowForm)
        <div class="mx-auto max-w-lg space-y-12">
            @if ($errorMessage)
                <x-panel.danger title="Error installing Nova" icon="tabler-alert-circle">
                    {{ $errorMessage }}
                </x-panel.danger>
            @endif

            <x-fieldset>
                <x-fieldset.field-group>
                    <x-fieldset.field
                        label="What’s the name of your game?"
                        id="game_name"
                        name="game_name"
                        :error="$errors->first('name')"
                    >
                        <x-input.text wire:model="name"></x-input.text>
                    </x-fieldset.field>

                    <x-fieldset.field label="What genre are you playing in?" id="game_genre" name="game_genre">
                        <x-select wire:model="genre">
                            <option value="st24">Star Trek (24th century)</option>
                        </x-select>
                    </x-fieldset.field>

                    @env('local')
                        <x-switch.field>
                            <x-fieldset.label for="should_seed">Install with demo data</x-fieldset.label>
                            <x-fieldset.description>
                                Automatically create users, characters, stories, posts, and other game data to simulate
                                how Nova would work with a fully operational game.
                            </x-fieldset.description>
                            <x-switch id="should_seed" wire:model="shouldSeed"></x-switch>
                        </x-switch.field>
                    @endenv
                </x-fieldset.field-group>
            </x-fieldset>

            <x-button.setup type="button" wire:click="install" size="sm">
                <div class="flex items-center gap-3">
                    <div>Start install</div>
                    <x-icon.loader
                        class="size-5 animate-spin text-white"
                        wire:loading
                        wire:target="install"
                    ></x-icon.loader>
                </div>
            </x-button.setup>
        </div>
    @endif

    @if ($shouldShowSuccessTable)
        <div class="mx-auto max-w-lg space-y-8">
            <x-panel well>
                <x-spacing size="2xs">
                    <x-panel class="divide-y divide-gray-950/5">
                        @include('setup.install-nova._check-installed')
                        @include('setup.install-nova._check-genre')
                        {{-- @include('setup.install-nova._check-app-url') --}}
                        @include('setup.install-nova._check-update-settings')
                    </x-panel>
                </x-spacing>
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
