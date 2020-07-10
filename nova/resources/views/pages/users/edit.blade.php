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
            </x-form.section>

            <x-form.section title="Avatar" message="User avatars should be a square image at least 500 pixels tall by 500 pixels wide, but not more than 5MB in size.">
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

            <x-form.section title="Characters">
                <x-input.group label="Assign characters">
                    @livewire('characters:collector', [
                        'characters' => old('characters', $user->characters->implode('id', ',')),
                        'user' => $user,
                    ])
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Update User</button>

                <a href="{{ route('users.index', "status={$user->status->name()}") }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>

    @can('deactivate', $user)
        <x-panel class="mt-8 p-4 | sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Deactivate User
            </h3>
            <div class="mt-2 | sm:flex sm:items-start sm:justify-between">
                <div class="w-full text-sm leading-6 font-medium text-gray-600">
                    <p>
                        When deactivating the user, all characters associated with the user that are not jointly owned with another user will be deactivated as well.
                    </p>
                </div>
                <div class="mt-5 | sm:mt-0 sm:ml-8 sm:flex-shrink-0 sm:flex sm:items-center">
                    <x-form :action="route('users.deactivate', $user)">
                        <button type="submit" class="button button-danger-soft">
                            Deactivate
                        </button>
                    </x-form>
                </div>
            </div>
        </x-panel>
    @endcan

    @can('activate', $user)
        <x-panel class="mt-8 p-4 | sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Activate User
            </h3>
            <div class="mt-2 | sm:flex sm:items-start sm:justify-between">
                <div class="w-full text-sm leading-6 font-medium text-gray-600">
                    <p>
                        When activating the user, their primary character will also be activated and their access roles will be set to the default roles for new users.
                    </p>
                </div>
                <div class="mt-5 | sm:mt-0 sm:ml-8 sm:flex-shrink-0 sm:flex sm:items-center">
                    <x-form :action="route('users.activate', $user)">
                        <button type="submit" class="button button-primary-soft">
                            Activate
                        </button>
                    </x-form>
                </div>
            </div>
        </x-panel>
    @endcan

    <x-panel class="mt-8 p-4 | sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Account Security
        </h3>

        @can('forcePasswordReset', $user)
            <div class="mt-6">
                <div class="rounded-md bg-gray-50 px-6 py-5 | sm:flex sm:items-start sm:justify-between">
                    <div class="sm:flex sm:items-start">
                        @icon('lock', 'flex-shrink-0 h-8 w-8 text-gray-500')
                        <div class="mt-3 | sm:mt-0 sm:ml-4">
                            <div class="text-sm leading-6 font-medium text-gray-600">
                                If you believe this user should reset their password, you can force a password reset that will prompt them to change their password the next time they attempt to sign in.
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-6 sm:flex-shrink-0">
                        <x-form :action="route('users.force-password-reset', $user)">
                            <span class="inline-flex rounded-md shadow-sm">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                    Force Password Reset
                                </button>
                            </span>
                        </x-form>
                    </div>
                </div>
            </div>
        @endcan

        <div class="mt-6">
            <div class="rounded-md bg-gray-50 px-6 py-5 | sm:flex sm:items-start sm:justify-between">
                <div class="sm:flex sm:items-start">
                    @icon('sign-out', 'flex-shrink-0 h-8 w-8 text-gray-500')
                    <div class="mt-3 | sm:mt-0 sm:ml-4">
                        <div class="text-sm leading-6 font-medium text-gray-600">
                            If necessary, you can sign a user out of their account. Be warned, if they're actively doing anything when you initiate this action, any work will be lost on their next page load.
                        </div>
                    </div>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-6 sm:flex-shrink-0">
                    <x-form :action="route('users.force-password-reset', $user)">
                        <span class="inline-flex rounded-md shadow-sm">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                Sign This User Out
                            </button>
                        </span>
                    </x-form>
                </div>
            </div>
        </div>
    </x-panel>
@endsection
