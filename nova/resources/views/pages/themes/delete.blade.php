<x-form :action="route('themes.destroy', $theme)" method="DELETE" id="form">
    <p>Are you sure you want to delete the <span class="font-semibold">{{ $theme->name }}</span> theme?</p>

    <p class="mt-6">The files for the theme will remain on the server, but you will no longer be able to use this theme on the public site.</p>
</x-form>
