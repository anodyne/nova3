<x-form :action="route('users.deactivate', $user)" id="form-deactivate" :divide="false">
    <p>Are you sure you want to deactivate <span class="font-semibold">{{ $user->name }}</span>?</p>

    <p class="mt-6">This will also deactivate all characters assigned to the user who are not jointly owned with another user.</p>
</x-form>
