<x-form :action="route('users.destroy', $user)" method="DELETE" id="form">
    Are you sure you want to delete the account for {{ $user->name }}? This will also delete all characters assigned to the user as well.
</x-form>
