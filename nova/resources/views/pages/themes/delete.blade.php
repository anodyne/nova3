<form action="{{ route('themes.destroy', $theme) }}" method="POST" role="form" id="form">
    @csrf
    @method('delete')

    Are you sure you want to delete the {{ $theme->name }} theme?
</form>
