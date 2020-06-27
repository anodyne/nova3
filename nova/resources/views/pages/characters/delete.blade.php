<x-form :action="route('users.destroy', $user)" method="DELETE" id="form">
    Are you sure you want to delete the account for {{ $user->name }}?
</x-form>
