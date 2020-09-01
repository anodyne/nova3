<x-form :action="route('ranks.groups.destroy', $group)" method="DELETE" id="form" :divide="false">
    Are you sure you want to delete the {{ $group->name }} rank group? This will also delete all ranks within the group and any characters with those ranks will need to have new ranks assigned to them.
</x-form>
