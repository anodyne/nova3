<form action="{{ route('notes.destroy', $note) }}" method="POST" role="form" id="form">
    @csrf
    @method('delete')

    Are you sure you want to delete {{ $note->title }}?
</form>
