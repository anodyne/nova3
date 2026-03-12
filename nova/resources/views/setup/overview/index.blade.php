@use('Nova\Setup\Enums\SetupType')

@php
    $e = nova()->environment();
@endphp

<x-setup-layout :type="nova()->isInstalled() ? 'update' : 'install'">
    <div class="mx-auto max-w-7xl space-y-16">
        <header class="mx-auto max-w-2xl space-y-6 text-center">
            <x-setup::page-heading>Welcome to Nova</x-setup::page-heading>

            @if ($e->fails())
                <x-setup::page-subheading>
                    Unfortunately it looks like your server doesn’t meet all of Nova’s requirements. Contact your web
                    host to correct these issues and try again.
                </x-setup::page-subheading>
            @else
                <x-setup::page-subheading>
                    This wizard will guide you through the Nova setup process, starting with ensuring Nova can connect
                    to your database.
                </x-setup::page-subheading>
            @endif
        </header>

        @if ($e->passes())
            <div class="flex items-center justify-center">
                @if ($component->type === SetupType::Update)
                    <x-setup::button :href="url('setup/update/whats-new')" :leading="Tabler::Speakerphone">
                        Learn about what’s new in this update
                    </x-setup::button>
                @else
                    <x-setup::button :href="url('setup/configure-database')" :leading="Tabler::DatabaseCog">
                        Connect to your database
                    </x-setup::button>
                @endif
            </div>
        @endif

        <div class="mx-auto max-w-2xl space-y-8">
            <x-setup::panel variant="well">
                <x-setup::panel class="grid grid-cols-[auto_1fr_auto] divide-y divide-gray-950/5" variant="inset">
                    @include('setup.overview._requirements-php')
                    @include('setup.overview._requirements-database')
                    @include('setup.overview._requirements-php-extensions')

                    @if (! nova()->isInstalled())
                        @include('setup.overview._requirements-nova2')
                    @endif
                </x-setup::panel>
            </x-setup::panel>
        </div>
    </div>
</x-setup-layout>
