<x-form :action="route('characters.deactivate', $character)" id="form-deactivate">
    Are you sure you want to deactivate <span class="font-semibold">{{ $character->name }}</span>?
</x-form>
