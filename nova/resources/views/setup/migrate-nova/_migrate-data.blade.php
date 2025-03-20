<x-spacing size="sm" class="col-span-3 grid grid-cols-subgrid">
    <div class="mr-4 shrink-0">
        <x-icon name="database-import" size="xl" class="text-gray-500"></x-icon>
    </div>

    <div class="col-start-2">
        <x-h4 class="leading-8">Migrate Nova 2 data</x-h4>
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 justify-end">
        @if ($status === null || ! $status?->isDatabaseConfigured())
            <x-icon name="circle-dashed" class="text-gray-400" size="xl"></x-icon>
        @elseif ($status->isDataMigrated())
            <x-icon name="check-circle" class="text-primary-500" size="xl"></x-icon>
        @else
            <x-button.setup :href="url('setup/migrate/steps')" size="xs">Go &rarr;</x-button.setup>
        @endif
    </div>
</x-spacing>
