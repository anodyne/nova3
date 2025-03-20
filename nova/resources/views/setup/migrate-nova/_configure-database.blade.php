<x-spacing size="sm" class="col-span-3 grid grid-cols-subgrid">
    <div class="mr-4 shrink-0">
        <x-icon name="database-settings" size="xl" class="text-gray-500"></x-icon>
    </div>

    <div class="col-start-2">
        <x-h4 class="leading-8">Configure database connection</x-h4>
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 justify-end">
        @if ($status?->isDatabaseConfigured())
            <x-icon name="check-circle" class="text-primary-500" size="xl"></x-icon>
        @else
            <x-button.setup :href="url('setup/migrate/configure-database')" size="xs">Go &rarr;</x-button.setup>
        @endif
    </div>
</x-spacing>
