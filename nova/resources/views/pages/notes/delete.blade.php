<x-form :action="route('notes.destroy', $note)" method="DELETE" id="form" :divide="false">
    Are you sure you want to delete this note? You won't be able to recover it.
</x-form>
