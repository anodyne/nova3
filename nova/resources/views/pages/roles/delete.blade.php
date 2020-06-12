<x-form :action="route('roles.destroy', $role)" method="DELETE" id="form">
    Are you sure you want to delete the {{ $role->display_name }} role?
</x-form>
