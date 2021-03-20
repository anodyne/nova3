@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add User">
        <x-slot name="pretitle">
            <a href="{{ route('users.index', 'status=active') }}">Users</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('users.store')">
            <x-form.section title="User Info">
                <x-slot name="message">
                    <p>For privacy reasons, we don't recommend using a user's real name. Instead, use a nickname to help protect their identity.</p>

                    <p class="block"><strong class="font-semibold">Note:</strong> after the account is created, a password will be generated and emailed to the new user.</p>
                </x-slot>

                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group label="Email address" for="email" :error="$errors->first('email')">
                    <x-input.email id="email" name="email" :value="old('email')" data-cy="email" />
                </x-input.group>

                <x-input.group label="Preferred pronouns" for="pronouns" :error="$errors->first('pronouns')">
                    <x-input.radio label="He/Him" for="male" name="pronouns" id="male" value="male" />

                    <span class="mx-6">
                        <x-input.radio label="She/Her" for="female" name="pronouns" id="female" value="female" />
                    </span>

                    <x-input.radio label="They/Them" for="neutral" name="pronouns" id="neutral" value="neutral" />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Avatar" message="User avatars should be a square image at least 500 pixels tall by 500 pixels wide, but not more than 5MB in size.">
                <x-input.group>
                    @livewire('upload-avatar')
                </x-input.group>
            </x-form.section>

            <x-form.section title="Roles">
                <x-slot name="message">
                    <p>Roles are a collection of the actions a user can take throughout Nova. A user can be assigned as many roles as you'd like, giving you more granular control over what users can do.</p>

                    @can('viewAny', 'Nova\Roles\Models\Role')
                        <div>
                            <x-button-link :href="route('roles.index')" color="white" size="xs">
                                Manage roles
                            </x-button-link>
                        </div>
                    @endcan
                </x-slot>

                <x-input.group label="Assign roles">
                    @livewire('roles:manage-roles', ['roles' => $defaultRoles])
                </x-input.group>
            </x-form.section>

            <x-form.section title="Characters">
                <x-input.group label="Assign characters">
                    @livewire('characters:collector', ['characters' => old('characters')])
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Add User</x-button>
                <x-button-link :href="route('users.index', 'status=active')" color="white">Cancel</x-button-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
