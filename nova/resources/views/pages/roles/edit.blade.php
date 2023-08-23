@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit role">
            <x-slot name="actions">
                @can('viewAny', Nova\Roles\Models\Role::class)
                    <x-button.text :href="route('roles.index')" leading="arrow-left" color="gray">Back</x-button.text>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('roles.update', $role)" method="PUT">
            <x-form.section title="Role details">
                <x-slot name="message">
                    <p>
                        A role is a collection of permissions that allows a user to take certain actions throughout
                        Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer
                        permissions to give yourself more freedom to add and remove access for a given user.
                    </p>

                    @if ($role->is_default)
                        <x-panel.warning icon="warning" title="Caution">
                            You are editing a role that is given to every new user. Exercise caution when making changes
                            to this role.
                        </x-panel.warning>
                    @endif
                </x-slot>
                <x-input.group label="Name" for="display_name" :error="$errors->first('display_name')">
                    <x-input.text
                        id="display_name"
                        name="display_name"
                        :value="old('display_name', $role->display_name)"
                        data-cy="display_name"
                    />
                </x-input.group>

                <x-input.group label="Key" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $role->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" rows="3" data-cy="description">
                        {{ old('description', $role->description) }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle name="is_default" :value="old('is_default', $role->is_default ?? false)">
                        Assign this role to new users
                    </x-switch-toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Permissions assigned to this role">
                <x-slot name="message">
                    There are {{ $role->permissions_count }} {{ str('permission')->plural($role->permissions_count) }}
                    assigned to this role. All assigned users below will have all of these permissions.
                </x-slot>

                <livewire:roles-manage-permissions :role="$role" />
            </x-form.section>

            <x-form.section title="Users assigned to this role">
                <x-slot name="message">
                    There are {{ $role->user_count }} active {{ str('user')->plural($role->user_count) }} assigned
                    this role. Users will have all of the permissions listed above.
                </x-slot>

                <livewire:roles-manage-users :role="$role" />
            </x-form.section>

            <x-form.footer class="mt-4 md:mt-8">
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.filled :href="route('roles.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
