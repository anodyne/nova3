<x-spacing size="sm" class="col-span-3 grid grid-cols-subgrid">
    <div class="mr-4 shrink-0">
        <x-icon name="versions" size="xl" class="text-gray-500"></x-icon>
    </div>

    <div class="col-start-2">
        <x-h4 class="leading-8">Insufficient Nova 2 version</x-h4>

        <div class="mt-2 space-y-4 text-sm/6 font-normal text-gray-500">
            <p>
                Migrating to Nova 3 requires that your existing Nova game be running at least
                <nobr class="font-semibold text-gray-950">Nova 2.7.13,</nobr>
                but your game is only running
                <nobr class="font-semibold text-danger-500">Nova {{ $legacyVersion }}.</nobr>
            </p>
            <p>
                Please update your game to a newer version of Nova 2, remove any Nova 3 tables from your database, and
                attempt the migration again.
            </p>
        </div>
    </div>

    <div class="col-start-3 ml-4 flex shrink-0 justify-end">
        <x-icon name="x-circle" class="text-danger-500" size="xl"></x-icon>
    </div>
</x-spacing>
