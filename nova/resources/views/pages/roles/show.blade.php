@extends($meta->template)

@section('content')
    <x-page-header :title="$role->display_name">
        <x-slot name="pretitle">
            <a href="{{ route('roles.index') }}">Roles</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $role)
                <x-link :href="route('roles.edit', $role)" color="blue">Edit Role</x-link>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel on-edge>
        <x-form action="">
            <x-form.section title="Role Info" message="A role is a collection of permissions that allows a user to take certain actions throughout Nova.">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $role->display_name }}</p>
                </x-input.group>

                <x-input.group label="Key">
                    <p class="font-semibold">{{ $role->name }}</p>
                </x-input.group>

                <x-input.group label="Assign to new users">
                    <p class="font-semibold">{{ $role->default ? 'Yes' : 'No' }}</p>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Permissions" message="Permissions are the actions a user can take.">
                <x-input.group>
                    <div class="flex items-center flex-wrap">
                        @forelse ($role->permissions as $permission)
                            <div class="badge mr-2 mt-3">
                                {{ $permission->display_name }}
                            </div>
                        @empty
                            <div class="flex items-center font-medium text-yellow-11">
                                @icon('warning', 'mr-3 flex-shrink-0 h-6 w-6 text-yellow-9')
                                <span>There are no permissions assigned to this role.</span>
                            </div>
                        @endforelse
                    </div>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Users" message="There are {{ $role->users->count() }} users who have been assigned this role.">
                <x-input.group>
                    <div class="flex items-center flex-wrap">
                        @forelse ($role->users as $user)
                            <div class="badge mr-2 mt-3">
                                {{ $user->name }}
                            </div>
                        @empty
                            <div class="flex items-center font-medium text-yellow-11">
                                @icon('warning', 'mr-3 flex-shrink-0 h-6 w-6 text-yellow-9')
                                <span>There are no users with this role.</span>
                            </div>
                        @endforelse
                    </div>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-link :href="route('roles.index')" color="white">Back</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
