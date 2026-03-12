<x-setup::panel.row :icon="Tabler::DatabaseSmile" heading="Optimize / repair database">
    <p>
        During the update process, Nova runs scripts to optimize and repair your database. These scripts address any
        data corruption, fix broken indexes, and ensure your database continues to run efficiently.
    </p>

    <x-slot name="trailing">
        <x-icon :name="Tabler::CircleCheck" class="text-primary-500" size="lg" />
    </x-slot>
</x-setup::panel.row>
