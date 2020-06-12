<x-form :action="route('notes.destroy', $note)" method="DELETE" id="form">
    Are you sure you want to delete {{ $note->title }}?
</x-form>
