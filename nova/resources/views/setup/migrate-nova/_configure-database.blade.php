<x-setup::panel.row :icon="Tabler::DatabaseCog" heading="Configure database connection">
    <x-slot name="trailing">
        @if ($status?->isDatabaseConfigured())
            <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
        @else
            <x-setup::button :href="url('setup/migrate/configure-database')" size="xs">
                Go
                <span aria-hidden="true">→</span>
            </x-setup::button>
        @endif
    </x-slot>
</x-setup::panel.row>
