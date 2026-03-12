<x-filament.modal-content :$action color="primary" title="Install pending add-on">
    <div class="prose">
        {!!
            str('Pending add-ons are ones which have been uploaded to the `addons` directory on your server, but have not been
            installed for use on your site yet.')->markdown()
        !!}
    </div>
</x-filament.modal-content>
