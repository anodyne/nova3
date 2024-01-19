@use('Nova\Setup\Enums\DatabaseConfigStatus')

<x-spacing size="sm" class="grid grid-cols-4 gap-4">
    <div class="col-span-3 font-medium text-gray-900">
        <div class="flex items-center gap-4">
            <div class="shrink-0">
                <x-icon name="tabler-settings-check" size="xl" class="text-gray-500"></x-icon>
            </div>
            <x-h4 class="flex-1">Verify database connection</x-h4>
        </div>
    </div>
    <div class="flex justify-end">
        <x-icon name="tabler-circle-check" class="text-primary-500" size="xl"></x-icon>
    </div>
</x-spacing>
