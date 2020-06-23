<x-form :action="route('ranks.items.destroy', $item)" method="DELETE" id="form">
    Are you sure you want to delete the {{ $item->name->name }} rank item from the {{ $item->group->name }} rank group? Any characters with this rank will need to have a new rank assigned to them.
</x-form>
