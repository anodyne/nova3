<div class="space-y-12">
    <x-add-ons.action-script :action="$action->getModalAction('rankSetInstall')" :icon="Icon::Bolt" title="Install">
        If you would like to install the rank set images, you can run the install script.

        <x-slot name="alert">
            This will delete all existing files from your ranks folder on the server. Make sure you have a backup copy
            of these images somewhere.
        </x-slot>
    </x-add-ons.action-script>

    <x-add-ons.action-script
        :action="$action->getModalAction('rankSetReplace')"
        :icon="Icon::PhotoAlert"
        title="Replace existing images"
    >
        This will replace any existing rank set images that are in the same folder structure and have the same name with
        the version from this add-on. Any rank images that are not in this add-on will be left alone.
    </x-add-ons.action-script>

    <x-add-ons.action-script
        :action="$action->getModalAction('rankSetAppend')"
        :icon="Icon::PhotoAdd"
        title="Add missing images"
    >
        This will add any rank set images that are not in the existing rank set images in the same folder structure.
    </x-add-ons.action-script>

    <x-add-ons.action-script
        :action="$action->getModalAction('rankSetUninstall')"
        :icon="Icon::BoltOff"
        color="danger"
        title="Uninstall"
    >
        If you would like to remove the rank set images, you can run the uninstall script.

        <x-slot name="alert">
            This will delete the files from your ranks folder on the server. Make sure you have a backup copy of these
            images somewhere.
        </x-slot>
    </x-add-ons.action-script>
</div>
