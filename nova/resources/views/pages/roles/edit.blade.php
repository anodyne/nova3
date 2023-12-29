@extends($meta->template)

@use('Nova\Roles\Models\Role')

@section('content')
    <x-container.narrow>
        <x-page-header>
            <x-slot name="heading">Edit role</x-slot>

            <x-slot name="actions">
                @can('viewAny', Role::class)
                    <x-button :href="route('roles.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form :action="route('roles.update', $role)" method="PUT">
            <x-fieldset>
                <x-fieldset.legend>Role details</x-fieldset.legend>
                <x-fieldset.description>
                    A role is a collection of permissions that allows a user to take certain actions throughout Nova.
                    Since a user can have as many roles as you’d like, we recommend creating roles with fewer
                    permissions to give yourself more freedom to add and remove access for a given user.
                </x-fieldset.description>

                @if ($role->is_default)
                    <x-panel.warning icon="warning" class="mt-4">
                        You are editing a role that is given to every new user. Exercise caution when making changes to
                        this role.
                    </x-panel.warning>
                @endif

                <x-fieldset.field-group class="w-full max-w-md">
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
                        <x-input.textarea id="description" name="description" data-cy="description" rows="3">
                            {{ old('description', $role->description) }}
                        </x-input.textarea>
                    </x-input.group>

                    <div class="flex items-center gap-x-2.5">
                        <x-switch
                            name="is_default"
                            :value="old('is_default', $role->is_default)"
                            id="is_default"
                        ></x-switch>
                        <x-fieldset.label for="is_default">Assign this role to new users</x-fieldset.label>
                    </div>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-panel well>
                    <x-container width="sm" height="sm">
                        <x-fieldset.legend>Permissions for this role</x-fieldset.legend>
                        <x-fieldset.description>
                            There are {{ $role->permissions_count }}
                            {{ str('permission')->plural($role->permissions_count) }} assigned to this role. All
                            assigned users will have these permissions.
                        </x-fieldset.description>
                    </x-container>

                    <x-container height="2xs" width="2xs">
                        <livewire:roles-manage-permissions :role="$role" />
                    </x-container>
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <x-panel well>
                    <x-container width="sm" height="sm">
                        <x-fieldset.legend>Users with this role</x-fieldset.legend>
                        <x-fieldset.description>
                            There are {{ $role->user_count }} active {{ str('user')->plural($role->user_count) }}
                            assigned this role. Users will have all of the permissions listed below.
                        </x-fieldset.description>
                    </x-container>

                    <x-container height="2xs" width="2xs">
                        <livewire:roles-manage-users :role="$role" />
                    </x-container>
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <div class="flex gap-x-2 lg:flex-row-reverse">
                    <x-button type="submit" color="primary">Update</x-button>
                    <x-button :href="route('roles.index')" plain>Cancel</x-button>
                </div>
            </x-fieldset>
        </x-form>
    </x-container.narrow>
@endsection
