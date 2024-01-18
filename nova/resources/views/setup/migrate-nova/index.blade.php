@use('Nova\Setup\Enums\NovaInstallStatus')

<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Migrate from Nova 2</h1>

        <p class="text-lg/8 text-gray-600">Easily move your existing data from Nova 2 to the new Nova 3 format.</p>
    </header>

    <div class="mx-auto max-w-lg space-y-8">
        <x-panel well>
            <x-spacing size="2xs">
                <x-panel class="divide-y divide-gray-950/5">
                    @include('setup.migrate-nova._configure-database')
                    @include('setup.migrate-nova._migrate-data')
                    @include('setup.migrate-nova._set-user-access')
                    @include('setup.migrate-nova._finalize-migration')
                </x-panel>
            </x-spacing>
        </x-panel>
    </div>
</div>
