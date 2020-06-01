@extends($__novaTemplate)

@section('content')
<x-page-header :title="$role->display_name">
    <x-slot name="pretitle">
        <a href="{{ route('roles.index') }}">Roles</a>
    </x-slot>
</x-page-header>

<x-panel>
    <form action="{{ route('roles.update', $role) }}" method="POST" role="form" data-cy="form">
        @csrf
        @method('put')

        <div class="form-section">
            <div class="form-section-header">
                <div class="form-section-header-title">Role info</div>
                <p class="form-section-header-message">A role is a collection of permissions that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer permissions to give yourself more freedom to add and remove access for a given user.</p>
            </div>

            <div class="form-section-content">
                <x-form-field
                    label="Name"
                    field-id="display_name"
                    name="display_name"
                >
                    <input
                        id="display_name"
                        type="text"
                        name="display_name"
                        class="field"
                        value="{{ old('display_name', $role->display_name) }}"
                        data-cy="display_name"
                    >
                </x-form-field>

                <x-form-field
                    label="Key"
                    field-id="name"
                    name="name"
                >
                    <input
                        id="name"
                        type="text"
                        name="name"
                        class="field"
                        value="{{ old('name', $role->name) }}"
                        data-cy="name"
                    >
                </x-form-field>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-header">
                <div class="form-section-header-title">Permissions</div>
                <p class="form-section-header-message">Permissions are the actions a signed in user can take throughout Nova. Feel free to add whatever permissions you want to this role.</p>
            </div>

            <div class="form-section-content">
                <x-form-field label="Assign permissions">
                    <x-slot name="clean">
                        Coming soon...
                    </x-slot>
                </x-form-field>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-header">
                <div class="form-section-header-title">Give users this role</div>
                <p class="form-section-header-message">You can quickly add users to this role from here.</p>
            </div>

            <div class="form-section-content">
                <x-form-field label="Assign users">
                    <x-slot name="clean">
                        Coming soon...
                    </x-slot>
                </x-form-field>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="button button-primary">Update Role</button>

            <a href="{{ route('roles.index') }}" class="button">
                Cancel
            </a>
        </div>
    </form>
</x-panel>
@endsection
