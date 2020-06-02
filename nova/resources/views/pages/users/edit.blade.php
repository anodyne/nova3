@extends($__novaTemplate)

@section('content')
<x-page-header :title="$user->name">
    <x-slot name="pretitle">
        <a href="{{ route('users.index') }}">Users</a>
    </x-slot>
</x-page-header>

<x-panel>
    <form action="{{ route('users.update', $user) }}" method="POST" role="form" data-cy="form">
        @csrf
        @method('put')

        <div class="form-section">
            <div class="form-section-header">
                <div class="form-section-header-title">User info</div>

                <p class="form-section-header-message mb-6">For privacy reasons, we don't recommend using a user's real name. Instead, use a nickname to help protect their identity.</p>

                <p class="form-section-header-message"><strong class="font-semibold">Note:</strong> after the account is created, a password will be generated and emailed to the new user.</p>
            </div>

            <div class="form-section-content">
                <x-form-field
                    label="Name"
                    field-id="name"
                    name="name"
                >
                    <input
                        id="name"
                        type="text"
                        name="name"
                        class="field"
                        value="{{ old('name', $user->name) }}"
                        data-cy="name"
                    >
                </x-form-field>

                <x-form-field
                    label="Email"
                    field-id="email"
                    name="email"
                >
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="field"
                        value="{{ old('email', $user->email) }}"
                        data-cy="email"
                    >
                </x-form-field>

                <x-form-field
                    label="Preferred pronouns"
                    field-id="gender"
                    name="gender"
                >
                    <x-slot name="clean">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="gender" value="male">
                            <span class="ml-2">He/Him</span>
                        </label>
                        <label class="inline-flex items-center mx-6">
                            <input type="radio" class="form-radio" name="gender" value="female">
                            <span class="ml-2">She/Her</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="gender" value="neutral">
                            <span class="ml-2">They/Them</span>
                        </label>
                    </x-slot>
                </x-form-field>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-header">
                <div class="form-section-header-title">Roles</div>

                <p class="form-section-header-message">Roles are made up of the actions a user can take throughout Nova. A user can be assigned as many roles as you'd like to give you more granular control over the actions they can perform.</p>

                @can('viewAny', 'Nova\Roles\Models\Role')
                    <a href="{{ route('roles.index') }}" class="button button-soft button-sm mt-6">
                        Manage roles
                    </a>
                @endcan
            </div>

            <div class="form-section-content">
                <x-form-field label="Assign Role(s)">
                    <x-slot name="clean">
                        Coming soon...
                    </x-slot>
                </x-form-field>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="button button-primary">Update User</button>

            <a href="{{ route('users.index') }}" class="button">
                Cancel
            </a>
        </div>
    </form>
</x-panel>
@endsection