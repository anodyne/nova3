<x-form :action="route('departments.destroy', $department)" method="DELETE" id="form" :divide="false">
    <p>Are you sure you want to delete the <span class="font-semibold">{{ $department->name }}</span> department?  You won't be able to recover it.</p>

    <p class="mt-6">All positions assigned to this department will be removed. Any characters assigned to a position that is removed will need to be re-assigned to another position.</p>
</x-form>
