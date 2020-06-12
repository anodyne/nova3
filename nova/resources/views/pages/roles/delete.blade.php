<form action="{{ route('roles.destroy', $role) }}" method="POST" role="form" id="form">
    @csrf
    @method('delete')

    Are you sure you want to delete the {{ $role->display_name }} role?
</form>
