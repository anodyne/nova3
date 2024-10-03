<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
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
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Role name">
                        <x-text>
                            {{ $role->display_name }}
                        </x-text>
                    </x-fieldset.field>

                    @if (filled($role->description))
                        <x-fieldset.field label="Description">
                            <x-text>
                                {{ $role->description }}
                            </x-text>
                        </x-fieldset.field>
                    @endif

                    @if ($role->is_default)
                        <div>
                            <x-badge color="success" size="md">Assigned to new users</x-badge>
                        </div>
                    @endif
                </x-fieldset.field-group>
            </x-fieldset>

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
</x-admin-layout>
