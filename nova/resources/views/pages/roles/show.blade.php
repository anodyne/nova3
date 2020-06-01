@extends($__novaTemplate)

@section('content')
<x-page-header :title="$role->display_name">
    <x-slot name="pretitle">
        <a href="{{ route('roles.index') }}">Roles</a>
    </x-slot>
</x-page-header>

<x-panel>
    <div class="form-section">
        <div class="form-section-header">
            <div class="form-section-header-title">Role info</div>
            <p class="form-section-header-message">A role is a collection of permissions that allows a user to take certain actions throughout Nova.</p>
        </div>

        <div class="form-section-content">
            <x-form-field
                label="Name"
                field-id="display_name"
                name="display_name"
            >
                <x-slot name="clean">
                    <p class="font-semibold">{{ $role->display_name }}</p>
                </x-slot>
            </x-form-field>

            <x-form-field
                label="Key"
                field-id="name"
                name="name"
            >
                <x-slot name="clean">
                    <p class="font-semibold">{{ $role->name }}</p>
                </x-slot>
            </x-form-field>
        </div>
    </div>

    <div class="form-section">
        <div class="form-section-header">
            <div class="form-section-header-title">Permissions</div>
            <p class="form-section-header-message mb-6">Permissions are the actions a user can take.</p>
        </div>

        <div class="form-section-content">
            <div class="flex items-center flex-wrap">
            @forelse ($role->permissions as $permission)
                <div class="badge mr-2 mt-3">
                    {{ $permission->display_name }}
                </div>
            @empty
                <div class="flex items-center font-medium text-warning-600">
                    @icon('warning', 'mr-3 flex-shrink-0 h-6 w-6 text-warning-400')
                    <span>There are no permissions assigned to this role.</span>
                </div>
            @endforelse
            </div>
        </div>
    </div>

    <div class="form-section">
        <div class="form-section-header">
            <div class="form-section-header-title">Users with this role</div>
            <p class="form-section-header-message">There are {{ $role->users_count }} users who have been assigned this role.</p>
        </div>

        <div class="form-section-content">
            <div class="flex items-center flex-wrap">
            @forelse ($role->users as $user)
                <div class="badge mr-2 mt-3">
                    {{ $user->name }}
                </div>
            @empty
                <div class="flex items-center font-medium text-warning-600">
                    @icon('warning', 'mr-3 flex-shrink-0 h-6 w-6 text-warning-400')
                    <span>There are no users with this role.</span>
                </div>
            @endforelse
            </div>
        </div>
    </div>

    <div class="form-footer">
        <a href="{{ route('roles.index') }}" class="button">
            Back
        </a>
    </div>
</x-panel>
@endsection
