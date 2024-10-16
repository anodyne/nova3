@use('Nova\Roles\Models\Role')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', Role::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.roles.index')" color="neutral" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.roles.update', $role)" method="PUT">
            <x-fieldset>
                @if ($role->is_default)
                    <x-panel.warning icon="warning" class="mt-4">
                        You’re editing a role that is given to every new user. Exercise caution when making changes to
                        this role.
                    </x-panel.warning>
                @endif

                <x-fieldset.field-group constrained>
                    <x-fieldset.field
                        label="Name"
                        name="display_name"
                        id="display_name"
                        :error="$errors->first('display_name')"
                    >
                        <x-input.text :value="old('display_name', $role->display_name)" data-cy="display_name" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Key" name="name" id="name" :error="$errors->first('name')">
                        <x-input.text :value="old('name', $role->name)" data-cy="name" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Description" name="description" id="description">
                        <x-input.textarea data-cy="description" rows="3">
                            {{ old('description', $role->description) }}
                        </x-input.textarea>
                    </x-fieldset.field>

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
                    <x-spacing size="sm">
                        <x-fieldset.legend>Permissions for this role</x-fieldset.legend>
                        <x-fieldset.description>
                            There are {{ $role->permissions_count }}
                            {{ str('permission')->plural($role->permissions_count) }} assigned to this role. All
                            assigned users will have these permissions.
                        </x-fieldset.description>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <livewire:roles-manage-permissions :role="$role" />
                    </x-spacing>
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Users with this role</x-fieldset.legend>
                        <x-fieldset.description>
                            There are {{ $role->user_count }} active {{ str('user')->plural($role->user_count) }}
                            assigned this role. Users will have all of the permissions listed below.
                        </x-fieldset.description>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <livewire:roles-manage-users :role="$role" />
                    </x-spacing>
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <div class="flex gap-x-2 lg:flex-row-reverse">
                    <x-button type="submit" color="primary">Update</x-button>
                    <x-button :href="route('admin.roles.index')" plain>Cancel</x-button>
                </div>
            </x-fieldset>
        </x-form>
    </x-spacing>
</x-admin-layout>
