<x-setup::panel.row :icon="Tabler::DatabaseImport" heading="Migrate Nova 2 data">
    <x-slot name="trailing">
        @if ($status === null || ! $status?->isDatabaseConfigured())
            <x-icon :name="Tabler::CircleDashed" class="text-gray-400" size="lg" />
        @elseif ($status->isDataMigrated())
            <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
        @else
            <x-setup::button :href="url('setup/migrate/steps')" size="xs">
                Go
                <span aria-hidden="true">→</span>
            </x-setup::button>
        @endif
    </x-slot>
</x-setup::panel.row>
