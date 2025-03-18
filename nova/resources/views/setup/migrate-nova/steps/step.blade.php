@use('Illuminate\Support\Number')

<div
    class="col-span-3 grid grid-cols-subgrid items-center p-4"
    x-data="{
        async runMigrationStep() {
            await $wire.migrate()
        },
    }"
    x-on:run-migration-step.window="
        if ($event.detail.id == $wire.__instance.id) {
            runMigrationStep()
        }
    "
    @if ($isBatchable)
        wire:poll.3.5s="updateBatchProgress"
    @endif
>
    <div class="mr-4 inline-flex shrink-0 items-center">
        <x-switch
            id="{{ str($label)->slug()->prepend('setup-migrate-') }}"
            wire:model="shouldMigrate"
            :disabled="! $canDisableMigration"
        ></x-switch>
    </div>

    <div class="col-start-2 flex items-center gap-2 font-medium text-gray-900">
        <div class="flex items-center gap-4">
            <div class="flex flex-1 items-center gap-3">
                <x-h4>{{ $label }}</x-h4>

                @if ($shouldMigrate)
                    <x-badge :color="$migrationCountBadgeColor">
                        {{ Number::format($pendingMigrationCount) }}
                        @if ($isFinished)
                            &rarr;
                            {{ Number::format($completedMigrationCount) }}
                        @endif
                    </x-badge>
                @endif
            </div>
        </div>
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 items-center justify-end">
        @if ($isRunning)
            <x-icon name="update" class="animate-reverse-spin text-gray-600" size="xl"></x-icon>
        @else
            @if ($isFinished)
                @if ($wasSuccessfullyMigrated)
                    <x-icon name="check-circle" class="text-primary-500" size="xl"></x-icon>
                @else
                    @if ($batchId)
                        <x-icon name="tabler-progress-bolt" class="text-warning-500" size="xl"></x-icon>
                    @else
                        <x-icon name="x-circle" class="text-danger-500" size="xl"></x-icon>
                    @endif
                @endif
            @else
                @if ($shouldMigrate)
                    <x-icon name="circle-dashed" class="text-gray-400" size="xl"></x-icon>
                @else
                    @if ($wasSuccessfullyMigrated)
                        <x-icon name="check-circle" class="text-primary-500" size="xl"></x-icon>
                    @else
                        <x-icon name="forbid" class="text-gray-400" size="xl"></x-icon>
                    @endif
                @endif
            @endif
        @endif
    </div>

    @if (! $wasSuccessfullyMigrated && filled($batchId))
        <div class="relative col-start-2 mt-4">
            <x-progress :percentage="$batchProgress" color="primary"></x-progress>
        </div>
        <div></div>
    @endif

    @if (filled($noteMessage))
        <div class="relative col-span-3 mt-4">
            <div class="flex gap-2 rounded-lg bg-gray-50 px-3 py-1 font-medium text-gray-500 ring-1 ring-gray-950/10">
                <div class="shrink-0 text-gray-400">
                    <x-icon.mini.info class="h-6 w-5" />
                </div>
                <div class="text-sm/6">
                    {!! $noteMessage !!}
                </div>
            </div>
        </div>
    @endif

    @if (! empty($errors))
        <div class="relative col-span-3 mt-4">
            <x-panel.danger title="Errors">
                <x-slot name="description">
                    <ul>
                        @foreach ($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-slot>
            </x-panel.danger>
        </div>
    @endif
</div>
