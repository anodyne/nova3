<form action="{{ route('users.destroy', $user) }}" method="POST" role="form" id="form">
    @csrf
    @method('delete')

    Are you sure you want to delete the account for {{ $user->name }}?
</form>
