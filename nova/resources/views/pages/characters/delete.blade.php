<x-form :action="route('characters.destroy', $character)" method="DELETE" id="form">
    Are you sure you want to delete <span class="font-semibold">{{ $character->name }}</span>?
</x-form>
