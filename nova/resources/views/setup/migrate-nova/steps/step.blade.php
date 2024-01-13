<x-spacing
    height="sm"
    class="grid grid-cols-4 gap-4 bg-white"
    x-data="{
        async runMigrationStep() {
            await $wire.migrate();
        }
    }"
    x-on:run-migration-step.window="if ($event.detail.id == $wire.__instance.id) { runMigrationStep(); }"
>
    <div class="col-span-3 flex items-center font-medium text-gray-900">
        <div class="flex items-center gap-4">
            <div class="shrink-0">
                <x-switch wire:model="shouldMigrate"></x-switch>
            </div>
            <div class="flex flex-1 items-center gap-3">
                <x-h4>{{ $label }}</x-h4>

                @if ($shouldMigrate)
                    <x-badge :color="$migrationCountBadgeColor">
                        {{ number_format($pendingMigrationCount) }}
                        @if ($isFinished)
                            &rarr;
                            {{ number_format($completedMigrationCount) }}
                        @endif
                    </x-badge>
                @endif
            </div>
        </div>
    </div>
    <div class="flex items-center justify-end">
        @if ($isRunning)
            <x-icon name="tabler-rotate-dot" class="animate-reverse-spin text-gray-600" size="xl"></x-icon>
        @else
            @if ($shouldMigrate)
                @if ($isFinished)
                    @if ($wasSuccessfullyMigrated)
                        <x-icon name="tabler-circle-check" class="text-primary-500" size="xl"></x-icon>
                    @else
                        <x-icon name="tabler-circle-x" class="text-danger-500" size="xl"></x-icon>
                    @endif
                @else
                    <x-icon name="tabler-circle-dashed" class="text-gray-400" size="xl"></x-icon>
                @endif
            @else
                @if ($wasSuccessfullyMigrated)
                    <x-icon name="tabler-circle-check" class="text-primary-500" size="xl"></x-icon>
                @else
                    <x-icon name="tabler-forbid-2" class="text-gray-400" size="xl"></x-icon>
                @endif
            @endif
        @endif
    </div>
</x-spacing>
