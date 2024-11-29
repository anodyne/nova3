<div class="space-y-12">
    <x-add-ons.action-script :action="$action->getModalAction('extensionInstall')" icon="bolt" title="Install">
        Generally you will only need to run the install script once, but there could be situations where you would want
        to run it multiple times. Consult with the add-on author before running the install script multiple times.
    </x-add-ons.action-script>

    <x-add-ons.action-script :action="$action->getModalAction('extensionUpdate')" icon="arrows-sync" title="Update">
        In some cases, an add-on may require additional scripts to be run as part of a version update. Consult with the
        add-on author about any steps that need to be taken before running the update script.
    </x-add-ons.action-script>

    <x-add-ons.action-script
        :action="$action->getModalAction('extensionUninstall')"
        icon="bolt-off"
        color="danger"
        title="Uninstall"
    >
        If for some reason you need to remove the add-on, but don't want to delete it, you can run the uninstall
        scripts. Consult with the add-on author before running the uninstall script.
    </x-add-ons.action-script>

    @if ($addonClass->hasMigrations())
        <x-add-ons.action-script
            :action="$action->getModalAction('extensionRunMigrations')"
            icon="database"
            title="Database migrations"
        >
            This will run the migrations to ensure any database structures are up-to-date.
        </x-add-ons.action-script>

        <x-add-ons.action-script
            :action="$action->getModalAction('extensionRollbackMigrations')"
            icon="database-off"
            color="danger"
            title="Rollback database migrations"
        >
            This will rollback the migrations to ensure any database structures have been removed.
        </x-add-ons.action-script>
    @endif
</div>
