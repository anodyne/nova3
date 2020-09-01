<x-form :action="route('users.destroy', $user)" method="DELETE" id="form" :divide="false">
    <p>Are you sure you want to delete the account for <span class="font-semibold">{{ $user->name }}</span>?</p>

    <p class="mt-6">This action is permanent and cannot be undone. This will also delete all characters assigned to the user as well.</p>
</x-form>
