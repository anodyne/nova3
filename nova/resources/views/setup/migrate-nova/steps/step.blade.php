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
            wire:model.live="shouldMigrate"
            :disabled="! $canDisableMigration"
        />
    </div>

    <div class="col-start-2 flex items-center gap-2 font-medium text-gray-900">
        <div class="flex items-center gap-4">
            <div class="flex flex-1 items-center gap-3">
                <x-setup::heading size="lg" level="2" class="leading-7">{{ $label }}</x-setup::heading>

                @if ($shouldMigrate)
                    <x-badge :color="$migrationCountBadgeColor">
                        {{ Number::format($pendingMigrationCount) }}
                        @if ($isFinished)
                            <span aria-hidden="true">&nbsp;→&nbsp;</span>
                            {{ Number::format($completedMigrationCount) }}
                        @endif
                    </x-badge>
                @endif
            </div>
        </div>
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 items-center justify-end">
        @if ($isRunning)
            <x-icon :name="Tabler::RefreshDot" class="animate-reverse-spin text-gray-600" size="xl" />
        @else
            @if ($isFinished)
                @if ($wasSuccessfullyMigrated)
                    <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="xl" />
                @else
                    @if ($batchId)
                        <x-icon :name="Tabler::ProgressBolt" class="text-warning-500" size="xl" />
                    @else
                        <x-icon :name="Tabler::CircleX" class="text-danger-500" size="xl" />
                    @endif
                @endif
            @else
                @if ($shouldMigrate)
                    <x-icon :name="Tabler::CircleDashed" class="text-gray-400" size="xl" />
                @else
                    @if ($wasSuccessfullyMigrated)
                        <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="xl" />
                    @else
                        <x-icon :name="Tabler::Forbid2" class="text-gray-400" size="xl" />
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
            <x-setup::callout icon="information-circle">
                {!! $noteMessage !!}
            </x-setup::callout>
        </div>
    @endif

    @if (! empty($errors))
        <div class="relative col-span-3 mt-4">
            <x-callout.danger heading="Errors" :icon="Tabler::AlertCircle">
                <ul>
                    @foreach ($errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-callout.danger>
        </div>
    @endif
</div>
