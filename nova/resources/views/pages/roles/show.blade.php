@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">{{ $role->display_name }}</x-slot>

            @if ($role->is_default)
                <x-slot name="description">
                    <div class="mt-2">
                        <x-badge color="success" size="md">Assigned to new users</x-badge>
                    </div>
                </x-slot>
            @endif

            <x-slot name="actions">
                @can('viewAny', $role::class)
                    <x-button :href="route('admin.roles.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $role)
                    <x-button :href="route('admin.roles.edit', $role)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form action="">
            <x-fieldset>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Permissions for this role</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel>
                            <x-spacing size="md">
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    @forelse ($role->permissions as $permission)
                                        <div>
                                            <x-fieldset.legend>{{ $permission->display_name }}</x-fieldset.legend>
                                            <x-fieldset.description>
                                                {{ $permission->description }}
                                            </x-fieldset.description>
                                        </div>
                                    @empty
                                        <div class="lg:col-span-2">
                                            <x-empty-state.small
                                                icon="key"
                                                title="No permissions assigned"
                                                message="There are no permissions assigned this role"
                                            ></x-empty-state.small>
                                        </div>
                                    @endforelse
                                </div>
                            </x-spacing>
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Users with this role</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel>
                            <x-spacing size="md">
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    @forelse ($role->user as $user)
                                        <x-avatar.user :user="$user"></x-avatar.user>
                                    @empty
                                        <div class="lg:col-span-2">
                                            <x-empty-state.small
                                                icon="users"
                                                title="No users assigned"
                                                message="There are no users assigned this role"
                                            ></x-empty-state.small>
                                        </div>
                                    @endforelse
                                </div>
                            </x-spacing>
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </x-fieldset>
        </x-form>
    </x-spacing>
@endsection
