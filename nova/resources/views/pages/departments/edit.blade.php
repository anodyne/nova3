@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$user->name">
        <x-slot name="pretitle">
            <a href="{{ route('users.index', "status={$user->status->name()}") }}">Users</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('users.update', $user)" method="PUT">
            <x-form.section title="User Info" message="For privacy reasons, we don't recommend using a user's real name. Instead, use a nickname to help protect their identity.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $user->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Email address" for="email" :error="$errors->first('email')">
                    <x-input.email id="email" name="email" :value="old('email', $user->email)" data-cy="email" />
                </x-input.group>

                <x-input.group label="Preferred pronouns" for="pronouns" :error="$errors->first('pronouns')">
                    <x-input.radio
                        label="He/Him"
                        for="male"
                        name="pronouns"
                        id="male"
                        value="male"
                        :checked="old('pronouns', $user->pronouns) === 'male'"
                        data-cy="pronouns"
                    />

                    <span class="mx-6">
                        <x-input.radio
                            label="She/Her"
                            for="female"
                            name="pronouns"
                            id="female"
                            value="female"
                            :checked="old('pronouns', $user->pronouns) === 'female'"
                            data-cy="pronouns"
                        />
                    </span>

                    <x-input.radio
                        label="They/Them"
                        for="neutral"
                        name="pronouns"
                        id="neutral"
                        value="neutral"
                        :checked="old('pronouns', $user->pronouns) === 'neutral'"
                        data-cy="pronouns"
                    />
                </x-input.group>

                <x-input.group label="Status" for="status">
                    <x-input.state-dropdown
                        :current-state="$user->status"
                        :states="$user->status->transitionableStates()"
                        name="status"
                        id="status"
                    />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Avatar" message="User avatars should be a square image at least 200 pixels tall by 200 pixels wide, but not more than 5MB in size.">
                <x-input.group>
                    @livewire('users:upload-avatar')
                </x-input.group>
            </x-form.section>

            <x-form.section title="Roles">
                <x-slot name="message">
                    <p>Roles are a collection of the actions a user can take throughout Nova. A user can be assigned as many roles as you'd like, giving you more granular control over what users can do.</p>

                    @can('viewAny', 'Nova\Roles\Models\Role')
                        <a href="{{ route('roles.index') }}" class="button button-soft button-sm mt-6">
                            Manage roles
                        </a>
                    @endcan
                </x-slot>

                <x-input.group label="Assign roles">
                    @livewire('roles:manage-roles', ['roles' => $user->roles])
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Update User</button>

                <a href="{{ route('users.index', "status={$user->status->name()}") }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
