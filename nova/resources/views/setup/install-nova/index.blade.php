@php
    $e = nova()->environment();
@endphp

<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <x-setup::page-heading>Install Nova</x-setup::page-heading>

        <x-setup::page-subheading>
            Tell us a little bit about your game before installing Nova.
        </x-setup::page-subheading>
    </header>

    @if ($shouldShowForm)
        <div class="mx-auto max-w-lg space-y-12">
            @if ($errorMessage)
                <x-callout.danger heading="Error installing Nova" :icon="Tabler::AlertCircle">
                    {{ $errorMessage }}
                </x-callout.danger>
            @endif

            <x-fieldset>
                <x-fieldset.fields>
                    <x-input label="What’s the name of your game?" wire:model="name" />

                    <x-select label="What genre are you playing in?" wire:model="genre">
                        <option value="">Do not install any genre data</option>
                        @foreach ($availableGenres as $genre => $name)
                            <option value="{{ $genre }}">{{ $name }}</option>
                        @endforeach
                    </x-select>

                    @env('local')
                        <x-switch
                            label="Install with demo data"
                            description="Automatically create users, characters, stories, posts, and other game data to simulate how Nova would work with a fully operational game"
                            wire:model.live="shouldSeed"
                        />
                    @endenv
                </x-fieldset.fields>
            </x-fieldset>

            <x-setup::button type="button" wire:click="install" size="sm">
                <div class="flex items-center gap-3">
                    <div>Start install</div>
                    <x-icon.loader
                        class="size-5 animate-spin text-white"
                        wire:loading
                        wire:target="install"
                    ></x-icon.loader>
                </div>
            </x-setup::button>
        </div>
    @endif

    @if ($shouldShowSuccessTable)
        <div class="mx-auto max-w-lg space-y-8">
            <x-panel variant="well">
                <x-panel class="grid grid-cols-[auto_1fr_auto] divide-y divide-gray-950/5" variant="inset">
                    @include('setup.install-nova._check-installed')
                    @include('setup.install-nova._check-installed-themes')
                    @includeWhen(filled($this->genre), 'setup.install-nova._check-genre')
                    {{-- @include('setup.install-nova._check-app-url') --}}
                    @include('setup.install-nova._check-update-settings')
                </x-panel>
            </x-panel>
        </div>

        <div class="flex items-center justify-center gap-8">
            @if ($e->database->driver !== 'pgsql')
                <x-setup::button href="{{ url('setup/migrate') }}" :leading="Tabler::ArrowForwardUpDouble">
                    Migrate your Nova 2 data
                </x-setup::button>

                <span class="text-sm font-semibold text-gray-500 uppercase">or</span>
            @endif

            <x-setup::button href="{{ url('setup/setup-account') }}">
                Continue as a fresh install
                <span aria-hidden="true">→</span>
            </x-setup::button>
        </div>
    @endif
</div>
