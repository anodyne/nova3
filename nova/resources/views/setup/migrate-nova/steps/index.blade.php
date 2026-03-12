<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <x-setup::page-heading>Migrate from Nova 2</x-setup::page-heading>

        <x-setup::page-subheading>
            You can choose which items you would like to migrate from Nova 2. Once you’ve made your selections, click
            the button to start the migrations process.
        </x-setup::page-subheading>
    </header>

    <div class="mx-auto max-w-lg space-y-8">
        <x-setup::panel variant="well">
            <x-setup::panel.header
                title="Available migrations"
                description="Choose which migrations you’d like to run for your Nova 2 site"
            ></x-setup::panel.header>

            <x-setup::panel class="grid grid-cols-[auto_1fr_auto] divide-y divide-gray-950/5">
                @foreach ($migrators as $migrator)
                    <livewire:is :component="$migrator" wire:key="setup-migrate-{{ str($migrator)->slug() }}" />
                @endforeach
            </x-setup::panel>
        </x-setup::panel>
    </div>

    @if ($isFinished)
        <div class="flex items-center justify-center">
            <x-setup::button :href="url('setup/migrate')">
                Continue migration
                <span aria-hidden="true">→</span>
            </x-setup::button>
        </div>
    @else
        <div class="flex items-center justify-center">
            @if (! $isRunning)
                <x-setup::button type="button" :leading="Tabler::PlayerPlay" wire:click="startMigration">
                    Start migration
                </x-setup::button>
            @else
                <x-setup::button type="button">
                    <div class="flex items-center gap-3">
                        <x-icon.loader class="size-5 animate-spin text-white"></x-icon.loader>
                        <div>Running migration</div>
                    </div>
                </x-setup::button>
            @endif
        </div>
    @endif
</div>
