<x-form :action="route('departments.destroy', $department)" method="DELETE" id="form">
    Are you sure you want to delete the {{ $department->name }} department? All positions within the department will be removed.
</x-form>
