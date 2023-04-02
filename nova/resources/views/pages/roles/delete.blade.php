<x-form :action="route('roles.destroy', $role)" method="DELETE" id="form" :divide="false">
    Are you sure you want to delete the <strong>{{ $role->display_name }}</strong> role?
</x-form>
