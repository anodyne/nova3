@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$role->display_name">
            <x-slot name="actions">
                @can('viewAny', $role::class)
                    <x-button.text :href="route('roles.index')" leading="arrow-left" color="gray">Back</x-button.text>
                @endcan

                @can('update', $role)
                    <x-button.filled :href="route('roles.edit', $role)" leading="edit" color="primary">Edit</x-button.filled>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form action="">
            <x-form.section title="Role Details" message="A role is a collection of permissions that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer permissions to give yourself more freedom to add and remove access for a given user.">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $role->display_name }}</p>
                </x-input.group>

                <x-input.group label="Key">
                    <p class="font-semibold">{{ $role->name }}</p>
                </x-input.group>

                @if ($role->default)
                    <div class="flex items-center space-x-2 font-medium text-success-600">
                        <x-icon name="check" size="md" class="shrink-0 text-success-500"></x-icon>
                        <span>Assigned to new users</span>
                    </div>
                @else
                    <div class="flex items-center space-x-2 font-medium text-danger-600">
                        <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500"></x-icon>
                        <span>Not assigned to new users</span>
                    </div>
                @endif
            </x-form.section>

            <x-form.section title="Assigned permissions" message="Any user assigned this role will have these permissions.">
                <div>
                    @foreach ($role->permissions as $permission)
                        <x-badge color="gray">{{ $permission->display_name }}</x-badge>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.section title="Assigned active users" message="The active users who are currently assigned this role.">
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                    @foreach ($users as $user)
                        <x-avatar.user :user="$user"></x-avatar.user>
                    @endforeach
                </div>
            </x-form.section>
        </x-form>
    </x-panel>
@endsection
