@extends($meta->template)

@use('Nova\Roles\Models\Role')

@section('content')
    <x-container.narrow>
        <x-page-header>
            <x-slot name="heading">Add a new role</x-slot>

            <x-slot name="actions">
                @can('viewAny', Role::class)
                    <x-button :href="route('roles.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <div
            x-data="{
                displayName: '{{ old('display_name') }}',
                name: '{{ old('name') }}',
                suggestName: true,
            }"
            x-init="
                $watch('displayName', (value) => {
                    if (suggestName) {
                        name = value
                            .toLowerCase()
                            .replace(/[^\w ]+/g, '')
                            .replace(/ +/g, '-')
                    }
                })
            "
        >
            <x-form :action="route('roles.store')">
                <x-fieldset>
                    <x-fieldset.legend>Role details</x-fieldset.legend>
                    <x-fieldset.description>
                        A role is a collection of permissions that allows a user to take certain actions throughout
                        Nova. Since a user can have as many roles as you’d like, we recommend creating roles with fewer
                        permissions to give yourself more freedom to add and remove access for a given user.
                    </x-fieldset.description>

                    <x-fieldset.field-group class="w-full max-w-md">
                        <x-input.group label="Name" for="display_name" :error="$errors->first('display_name')">
                            <x-input.text
                                x-model="displayName"
                                id="display_name"
                                name="display_name"
                                data-cy="display_name"
                            />
                        </x-input.group>

                        <x-input.group label="Key" for="name" :error="$errors->first('name')">
                            <x-input.text
                                x-model="name"
                                @change="suggestName = false"
                                id="name"
                                name="name"
                                data-cy="name"
                            />
                        </x-input.group>

                        <x-input.group label="Description" for="description">
                            <x-input.textarea id="description" name="description" data-cy="description" rows="3">
                                {{ old('description') }}
                            </x-input.textarea>
                        </x-input.group>

                        <div class="flex items-center gap-x-2.5">
                            <x-switch name="is_default" :value="old('is_default')" id="is_default"></x-switch>
                            <x-fieldset.label for="is_default">Assign this role to new users</x-fieldset.label>
                        </div>
                    </x-fieldset.field-group>
                </x-fieldset>

                <x-fieldset>
                    <x-panel well>
                        <x-container width="sm" height="sm">
                            <x-fieldset.legend>Permissions for this role</x-fieldset.legend>
                            <x-fieldset.description>
                                These permissions will be added to the role when it’s created.
                            </x-fieldset.description>
                        </x-container>

                        <x-container height="2xs" width="2xs">
                            <livewire:roles-manage-permissions />
                        </x-container>
                    </x-panel>
                </x-fieldset>

                <x-fieldset>
                    <x-panel well>
                        <x-container width="sm" height="sm">
                            <x-fieldset.legend>Users with this role</x-fieldset.legend>
                            <x-fieldset.description>
                                These users will be assigned this role and have all of the permissions listed below when
                                it’s created.
                            </x-fieldset.description>
                        </x-container>

                        <x-container height="2xs" width="2xs">
                            <livewire:roles-manage-users />
                        </x-container>
                    </x-panel>
                </x-fieldset>

                <x-fieldset>
                    <div class="flex gap-x-2 lg:flex-row-reverse">
                        <x-button type="submit" color="primary">Add</x-button>
                        <x-button :href="route('roles.index')" plain>Cancel</x-button>
                    </div>
                </x-fieldset>
            </x-form>
        </div>
    </x-container.narrow>
@endsection
