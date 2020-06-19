<x-form :action="route('ranks.names.destroy', $name)" method="DELETE" id="form">
    Are you sure you want to delete the {{ $name->name }} rank name? This will also delete all ranks with the name and any characters with those ranks will have to have new ranks assigned to them.
</x-form>
