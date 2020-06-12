@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$role->display_name">
        <x-slot name="pretitle">
            <a href="{{ route('roles.index') }}">Roles</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        @if ($role->default)
            <div class="bg-info-100 border-t border-b border-info-200 p-4 | sm:rounded-t-md sm:border-t-0">
                <div class="flex">
                    <div class="flex-shrink-0">
                        @icon('check-alt', 'h-6 w-6 text-info-600')
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm leading-5 font-medium text-info-900">
                            Default role for new users
                        </h3>
                        <div class="mt-2 text-sm leading-5 text-info-800">
                            <p>New users are automatically assigned this role when they're activated. Be careful when making any updates to ensure new users have the correct permissions.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('roles.update', $role) }}" method="POST" role="form" data-cy="form">
            @csrf
            @method('put')

            <input type="hidden" name="id" value="{{ $role->id }}">

            <x-form.section title="Role Info" message="A role is a collection of permissions that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer permissions to give yourself more freedom to add and remove access for a given user.">
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
                    <x-input.textarea id="description" name="description" rows="3" data-cy="description">{{ old('description', $role->description) }}</x-input.textarea>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="default" :value="old('default', $role->default ?? '')">
                        Assign this role to new users
                    </x-input.toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Permissions" message="Permissions are the actions a signed in user can take throughout Nova. Feel free to add whatever permissions you want to this role.">
                <x-input.group label="Assign permissions">
                    @livewire('roles:manage-permissions', ['permissions' => $role->permissions])
                </x-input.group>
            </x-form.section>

            <x-form.section title="Users" message="You can quickly add users to this role from here.">
                <x-input.group label="Assign users">
                    @livewire('users:manage-users', ['users' => $role->users])
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Update Role</button>

                <a href="{{ route('roles.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </form>
    </x-panel>
@endsection
