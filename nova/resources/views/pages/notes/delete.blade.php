<x-form :action="route('notes.destroy', $note)" method="DELETE" id="form" :divide="false">
    Are you sure you want to delete your <span class="font-semibold">{{ $note->title }}</span> note? This action is permanent and cannot be undone.
</x-form>
