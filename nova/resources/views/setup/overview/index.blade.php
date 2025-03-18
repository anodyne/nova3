@use('Nova\Setup\Enums\SetupType')

@php
    $e = nova()->environment();
@endphp

<x-setup-layout :type="nova()->isInstalled() ? 'update' : 'install'">
    <div class="mx-auto max-w-7xl space-y-16">
        <header class="mx-auto max-w-2xl space-y-6 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Welcome to Nova</h1>

            @if ($e->fails())
                <p class="text-lg/8 text-gray-600">
                    Unfortunately it looks like your server doesn’t meet all of Nova’s requirements. Contact your web
                    host to correct these issues and try again.
                </p>
            @else
                <p class="text-lg/8 text-gray-600">
                    This wizard will guide you through the Nova setup process, starting with ensuring Nova can connect
                    to your database.
                </p>
            @endif
        </header>

        @if ($e->passes())
            <div class="flex items-center justify-center">
                @if ($component->type === SetupType::Update)
                    <x-button.setup :href="url('setup/update/whats-new')" leading="megaphone">
                        Learn about what’s new in this update
                    </x-button.setup>
                @else
                    <x-button.setup :href="url('setup/configure-database')" leading="database-settings">
                        Connect to your database
                    </x-button.setup>
                @endif
            </div>
        @endif

        <div class="mx-auto max-w-2xl space-y-8">
            <x-panel variant="well">
                <x-panel class="divide-y divide-gray-950/5" variant="inset">
                    @include('setup.overview._requirements-php')
                    @include('setup.overview._requirements-database')
                    @include('setup.overview._requirements-php-extensions')
                </x-panel>
            </x-panel>
        </div>
    </div>
</x-setup-layout>
