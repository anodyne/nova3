<div class="mx-auto max-w-7xl space-y-16">
    <header class="mx-auto max-w-2xl space-y-6 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Migrate from Nova 2</h1>

        <p class="text-lg/8 text-gray-600">
            You can choose which items you would like to migrate from Nova 2. Once you’ve made your selections, click
            the button to start the migrations process.
        </p>
    </header>

    <div class="mx-auto max-w-lg space-y-8">
        <x-panel class="overflow-hidden">
            <div class="divide-y divide-gray-200">
                <livewire:setup-migrate-users />
                <livewire:setup-migrate-departments />
                <livewire:setup-migrate-positions />
                <livewire:setup-migrate-characters />
                <livewire:setup-migrate-missions />
                <livewire:setup-migrate-posts />
                <livewire:setup-migrate-logs />
                <livewire:setup-migrate-news />
            </div>
        </x-panel>
    </div>

    <div class="flex items-center justify-center">
        @if (! $isRunning)
            <x-button.setup type="button" leading="tabler-player-play" wire:click="startMigration">
                Start migration
            </x-button.setup>
        @else
            <x-button.setup type="button">
                <div class="flex items-center gap-3">
                    <x-icon.loader class="h-5 w-5 animate-spin text-white"></x-icon.loader>
                    <div>Running migration</div>
                </div>
            </x-button.setup>
        @endif
    </div>

    @if ($isFinished)
        <div class="flex items-center justify-center">
            <x-button.setup type="button" leading="tabler-player-play">Finish migration</x-button.setup>
        </div>
    @endif
</div>
