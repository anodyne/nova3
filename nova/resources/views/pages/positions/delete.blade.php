<x-form :action="route('positions.destroy', $position)" method="DELETE" id="form">
    <p>Are you sure you want to delete the <span class="font-semibold">{{ $position->name }}</span> from the {{ $position->department->name}} department?</p>

    <p class="mt-6">This action is permanent and cannot be undone. Any characters assigned to the position will have to have a new position manually assigned to them.</p>
</x-form>
