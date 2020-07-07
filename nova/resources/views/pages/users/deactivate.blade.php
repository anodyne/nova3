<x-form :action="route('users.deactivate', $user)" id="form-deactivate">
    Are you sure you want to deactivate <span class="font-semibold">{{ $user->name }}</span>? This will also deactivate all characters assigned to them that are not jointly owned with another user.
</x-form>
