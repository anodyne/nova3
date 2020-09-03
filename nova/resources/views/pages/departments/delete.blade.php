<x-form :action="route('departments.destroy', $department)" method="DELETE" id="form" :divide="false">
    <p>Are you sure you want to delete the <span class="font-semibold">{{ $department->name }}</span> department?</p>

    <p class="mt-6">This action is permanent and cannot be undone. All positions within the department will be removed and characters assigned to a position within the department will need to be manually reassigned to another position.</p>
</x-form>
