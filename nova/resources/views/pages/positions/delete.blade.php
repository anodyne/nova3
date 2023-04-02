<x-form :action="route('positions.destroy', $position)" method="DELETE" id="form" :divide="false">
    <p>Are you sure you want to delete the <span class="font-semibold">{{ $position->name }}</span> from the {{ $position->department->name}} department? You won't be able to recover it.</p>

    <p class="mt-6">Any characters assigned to this position will need to be re-assigned to another position.</p>
</x-form>
