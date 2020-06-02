@extends($__novaTemplate)

@section('content')
<x-page-header :title="$user->name">
    <x-slot name="pretitle">
        <a href="{{ route('users.index') }}">Users</a>
    </x-slot>
</x-page-header>

<x-panel>
    <div class="form-section">
        <div class="form-section-header">
            <div class="form-section-header-title">User info</div>
            <p class="form-section-header-message">For privacy reasons, users are encouraged to use a nickname instead of their real name. Additionally, user email addresses should be safeguarded at all costs and not shared with other players without the express permission of this user.</p>
        </div>

        <div class="form-section-content">
            <x-form-field
                label="Name"
                field-id="name"
                name="name"
            >
                <x-slot name="clean">
                    <p class="font-semibold">{{ $user->name }}</p>
                </x-slot>
            </x-form-field>

            <x-form-field
                label="Email"
                field-id="email"
                name="email"
            >
                <x-slot name="clean">
                    <p class="font-semibold">{{ $user->email }}</p>
                </x-slot>
            </x-form-field>

            <x-form-field
                label="Preferred pronouns"
                field-id="pronouns"
                name="pronouns"
            >
                <x-slot name="clean">
                    <p class="font-semibold">{{ $user->pronouns }}</p>
                </x-slot>
            </x-form-field>

            <x-form-field
                label="Avatar"
                field-id="avatar"
                name="avatar"
            >
                <x-slot name="clean">
                    <x-avatar :url="$user->avatar_url" size="lg"></x-avatar>
                </x-slot>
            </x-form-field>
        </div>
    </div>

    <div class="form-section">
        <div class="form-section-header">
            <div class="form-section-header-title">Roles</div>
            <p class="form-section-header-message mb-6">Roles are the actions a user can take.</p>
        </div>

        <div class="form-section-content">
            <div class="flex items-center flex-wrap">
            @forelse ($user->roles as $role)
                <span class="badge mr-2 mt-3">
                    {{ $role->display_name }}
                </span>
            @empty
                <div class="flex items-center font-semibold text-warning-700">
                    @icon('warning', 'mr-3 flex-shrink-0 h-6 w-6')
                    <span>This user does not have any roles.</span>
                </div>
            @endforelse
            </div>
        </div>
    </div>

    <div class="form-footer">
        <a href="{{ route('users.index') }}" class="button">
            Back
        </a>
    </div>
</x-panel>
@endsection