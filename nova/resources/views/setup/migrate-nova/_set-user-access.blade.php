<x-setup::panel.row :icon="Tabler::ShieldLock" heading="Set system administrator">
    <x-slot name="trailing">
        @if ($status === null || ! $status?->isDatabaseConfigured() || ! $status?->isDataMigrated())
            <x-icon :name="Tabler::CircleDashed" class="text-gray-400" size="lg" />
        @elseif ($status->isUserAccessUpdated())
            <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
        @else
            <x-setup::button :href="url('setup/migrate/set-user-access')" size="xs">
                Go
                <span aria-hidden="true">→</span>
            </x-setup::button>
        @endif
    </x-slot>
</x-setup::panel.row>
