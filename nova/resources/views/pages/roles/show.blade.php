@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :message="$role->name">
            <x-slot name="title">
                <div class="flex items-center gap-4">
                    <span>{{ $role->display_name }}</span>

                    @if ($role->is_default)
                        <div class="flex items-center">
                            <x-badge color="success">Assigned to new users</x-badge>
                        </div>
                    @endif
                </div>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', $role::class)
                    <x-button.text :href="route('roles.index')" leading="arrow-left" color="gray">Back</x-button.text>
                @endcan

                @can('update', $role)
                    <x-button.filled :href="route('roles.edit', $role)" leading="edit" color="primary">
                        Edit
                    </x-button.filled>
                @endcan
            </x-slot>
        </x-panel.header>

        <div class="flex flex-col divide-gray-200 lg:flex-row lg:divide-x">
            <div class="flex flex-1 flex-col gap-6 divide-y divide-gray-200">
                <x-content-box class="flex flex-col gap-4">
                    <x-h3>Users</x-h3>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                        @foreach ($role->user as $user)
                            <x-panel as="light-well" class="group flex w-full items-center justify-between">
                                <x-content-box height="sm" width="sm">
                                    <x-avatar.user :user="$user"></x-avatar.user>
                                </x-content-box>
                            </x-panel>
                        @endforeach
                    </div>
                </x-content-box>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="flex w-full flex-col">
                    <div class="flex items-center justify-between px-4 py-4">
                        <x-h3>Permissions</x-h3>
                    </div>

                    <div>
                        @foreach ($role->permissions as $permission)
                            <div
                                class="group flex items-center justify-between px-4 py-2 odd:bg-gray-100 dark:odd:bg-gray-700/50"
                            >
                                {{ $permission->display_name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-panel>
@endsection
