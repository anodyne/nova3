<x-setup::panel.row :icon="Tabler::Versions" heading="Insufficient Nova 2 version">
    <p>
        Migrating to Nova 3 requires that your existing Nova game be running at least
        <nobr class="font-semibold text-gray-950">Nova 2.7.13,</nobr>
        but your game is only running
        <nobr class="text-danger-500 font-semibold">Nova {{ $legacyVersion }}.</nobr>
    </p>
    <p>
        Please update your game to a newer version of Nova 2, remove any Nova 3 tables from your database, and attempt
        the migration again.
    </p>

    <x-slot name="trailing">
        <x-icon :name="Tabler::CircleX" class="text-danger-500" size="lg" />
    </x-slot>
</x-setup::panel.row>
