<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Migrate from Nova 2</h1>

        <p class="text-lg/8 text-gray-600">
            You can choose which items you would like to migrate from Nova 2. Once you’ve made your selections, click
            the button to start the migrations process.
        </p>
    </header>

    <div class="mx-auto max-w-lg space-y-8">
        <x-panel variant="well">
            <x-panel.header
                title="Available migrations"
                description="Choose which migrations you want to run for your Nova 2 site."
            ></x-panel.header>

            <x-panel class="grid grid-cols-[auto_1fr_auto] divide-y divide-gray-950/5">
                @foreach ($migrators as $migrator)
                    <livewire:is :component="$migrator" wire:key="setup-migrate-{{ str($migrator)->slug() }}" />
                @endforeach
            </x-panel>
        </x-panel>
    </div>

    @if ($isFinished)
        <div class="flex items-center justify-center">
            <x-button.setup :href="url('setup/migrate')">Continue migration &rarr;</x-button.setup>
        </div>
    @else
        <div class="flex items-center justify-center">
            @if (! $isRunning)
                <x-button.setup type="button" :leading="Icon::PlayerPlay" wire:click="startMigration">
                    Start migration
                </x-button.setup>
            @else
                <x-button.setup type="button">
                    <div class="flex items-center gap-3">
                        <x-icon.loader class="size-5 animate-spin text-white"></x-icon.loader>
                        <div>Running migration</div>
                    </div>
                </x-button.setup>
            @endif
        </div>
    @endif
</div>
