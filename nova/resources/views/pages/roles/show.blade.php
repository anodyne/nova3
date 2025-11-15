<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading :heading="$role->display_name">
            @if ($role->is_default)
                <x-slot name="description">
                    <x-badge color="success" size="md">Assigned to new users</x-badge>
                </x-slot>
            @endif

            @if (filled($role->description))
                <x-slot name="intro">
                    {{ $role->description }}
                </x-slot>
            @endif

            <x-slot name="actions">
                @can('viewAny', $role::class)
                    <x-button :href="route('admin.roles.index')" variant="ghost">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                @endcan

                @can('update', $role)
                    <x-button :href="route('admin.roles.edit', $role)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm" />
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-heading>

        <x-form action="">
            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Permissions for this role"></x-panel.header>

                    <x-panel>
                        <x-spacing size="md">
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                @forelse ($role->permissions as $permission)
                                    <div>
                                        <x-heading level="4">{{ $permission->display_name }}</x-heading>
                                        <x-description>
                                            {{ $permission->description }}
                                        </x-description>
                                    </div>
                                @empty
                                    <div class="lg:col-span-2">
                                        <x-empty>
                                            <x-illustration :name="Illustration::PadlockShield" />
                                            <x-empty.heading>No permissions assigned</x-empty.heading>
                                            <x-empty.text>There are no permissions assigned this role</x-empty.text>
                                        </x-empty>
                                    </div>
                                @endforelse
                            </div>
                        </x-spacing>
                    </x-panel>
                </x-panel>
            </x-fieldset>

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Users with this role"></x-panel.header>

                    <x-panel>
                        <x-spacing size="md">
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                @forelse ($role->user as $user)
                                    <x-avatar.user :$user status></x-avatar.user>
                                @empty
                                    <div class="lg:col-span-2">
                                        <x-empty>
                                            <x-illustration :name="Illustration::Users" />
                                            <x-empty.heading>No users assigned</x-empty.heading>
                                            <x-empty.text>There are no users assigned this role</x-empty.text>
                                        </x-empty>
                                    </div>
                                @endforelse
                            </div>
                        </x-spacing>
                    </x-panel>
                </x-panel>
            </x-fieldset>
        </x-form>
    </x-spacing>
</x-admin-layout>
