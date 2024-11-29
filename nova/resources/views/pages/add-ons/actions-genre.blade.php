<div class="space-y-12">
    <x-add-ons.action-script :action="$action->getModalAction('genreInstall')" icon="bolt" title="Install">
        Generally you will only need to run the install script once, but there could be situations where you would want
        to run it multiple times. Consult with the add-on author before running the install script multiple times.

        <x-slot name="alert">
            This will remove all department, position, and rank data in the database. You will be required to make
            significant updates to any existing characters to ensure they're in the correct position and have the
            correct rank.
        </x-slot>
    </x-add-ons.action-script>

    <x-add-ons.action-script :action="$action->getModalAction('genreUpdate')" icon="arrows-sync" title="Update">
        This will attempt to update the genre data with the latest version from the add-on.

        <x-slot name="warning">
            This could cause updates to your existing department, position, and rank data. Make sure you understand the
            changes that will be attempted if you have made any changes to your genre data.
        </x-slot>
    </x-add-ons.action-script>

    <x-add-ons.action-script
        :action="$action->getModalAction('genreUninstall')"
        icon="bolt-off"
        color="danger"
        title="Uninstall"
    >
        If for some reason you need to remove the add-on, but don't want to delete it, you can run the uninstall
        scripts. Consult with the add-on author before running the uninstall script.

        <x-slot name="alert">This will remove all department, position, and rank data from the database.</x-slot>
    </x-add-ons.action-script>
</div>
