<x-content-box height="sm" class="grid grid-cols-4 gap-4 bg-white">
    <div class="col-span-3 font-medium text-gray-900">
        <div class="flex items-center gap-4">
            <div class="shrink-0">
                <x-icon name="tabler-database-cog" size="xl" class="text-gray-500"></x-icon>
            </div>
            <x-h4 class="flex-1">Configure database connection</x-h4>
        </div>
    </div>
    <div class="flex justify-end">
        @if ($status?->isDatabaseConfigured())
            <x-icon name="tabler-circle-check" class="text-primary-500" size="xl"></x-icon>
        @else
            <x-button.setup :href="url('setup/migrate/configure-database')" size="xs">Go &rarr;</x-button.setup>
        @endif
    </div>
</x-content-box>
