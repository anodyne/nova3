<x-form :action="route('themes.destroy', $theme)" method="DELETE" id="form">
    Are you sure you want to delete the {{ $theme->name }} theme?
</x-form>
