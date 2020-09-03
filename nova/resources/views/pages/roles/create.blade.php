@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Role">
        <x-slot name="pretitle">
            <a href="{{ route('roles.index') }}">Roles</a>
        </x-slot>
    </x-page-header>

    <x-panel
        x-data="{ displayName: '{{ old('display_name') }}', name: '{{ old('name') }}', suggestName: true }"
        x-init="
            $watch('displayName', value => {
                if (suggestName) {
                    name = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
                }
            })
        "
    >
        <x-form :action="route('roles.store')">
            <x-form.section title="Role Info" message="A role is a collection of permissions that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer permissions to give yourself more freedom to add and remove access for a given user.">
                <x-input.group label="Name" for="display_name" :error="$errors->first('display_name')">
                    <x-input.text x-model="displayName" id="display_name" name="display_name" data-cy="display_name" />
                </x-input.group>

                <x-input.group label="Key" for="name" :error="$errors->first('name')">
                    <x-input.text x-model="name" x-on:change="suggestName = false" id="name" name="name" data-cy="name" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="3">{{ old('description') }}</x-input.textarea>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="default" :value="old('default')">
                        Assign this role to new users
                    </x-input.toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Permissions" message="Permissions are the actions a signed in user can take throughout Nova. Feel free to add whatever permissions you want to this role.">
                <x-input.group label="Assign permissions">
                    @livewire('roles:manage-permissions', ['permissions' => []])
                </x-input.group>
            </x-form.section>

            <x-form.section title="Users" message="You can quickly add users to this role from here.">
                <x-input.group label="Assign users">
                    @livewire('users:manage-users', ['users' => []])
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Add Role</x-button>
                <x-button-link :href="route('roles.index')" color="white">Cancel</x-button-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
