<x-form :action="route('positions.destroy', $position)" method="DELETE" id="form">
    Are you sure you want to delete the {{ $position->name }} from the {{ $position->department->name}} department? Any characters with this position will need to have a new position assigned to them.
</x-form>
