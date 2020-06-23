<x-form :action="route('ranks.items.destroy', $item)" method="DELETE" id="form">
    Are you sure you want to delete this rank item? Any characters with this rank will have to have a new rank assigned to them.
</x-form>
