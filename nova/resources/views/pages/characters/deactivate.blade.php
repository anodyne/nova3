<x-form :action="route('characters.deactivate', $character)" id="form-deactivate" :divide="false">
    Are you sure you want to deactivate <span class="font-semibold">{{ $character->name }}</span>?
</x-form>
