@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$user->name">
        <x-slot name="pretitle">
            <a href="{{ route('users.index', "status={$user->state}") }}">Users</a>
        </x-slot>
    </x-page-header>

    <x-under-construction feature="Users">
        <li>Roles cannot be updated for a user</li>
        <li>User status cannot be changed</li>
    </x-under-construction>

    <x-panel>
        <form action="{{ route('users.update', $user) }}" method="POST" role="form" data-cy="form">
            @csrf
            @method('put')

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
                        label="They/Theme"
                        for="neutral"
                        name="pronouns"
                        id="neutral"
                        value="neutral"
                        :checked="old('pronouns', $user->pronouns) === 'neutral'"
                        data-cy="pronouns"
                    />
                </x-input.group>

                <x-input.group label="Status" for="status">
                    <select name="status" id="status" class="form-select w-full | sm:w-1/2">
                        <option value="{{ $user->status }}">{{ ucfirst($user->status->name()) }}</option>
                        @foreach ($user->status->transitionableStates() as $status)
                            <option value="{{ $status }}">{{ collect(explode('\\', $status))->last() }}</option>
                        @endforeach
                    </select>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Avatar">
                <x-input.group>
                    @livewire('users:upload-avatar')
                </x-input.group>
            </x-form.section>

            <x-form.section title="Roles">
                <x-slot name="message">
                    Roles are made up of the actions a user can take throughout Nova. A user can be assigned as many roles as you'd like to give you more granular control over the actions they can perform.

                    @can('viewAny', 'Nova\Roles\Models\Role')
                        <a href="{{ route('roles.index') }}" class="button button-soft button-sm mt-6">
                            Manage roles
                        </a>
                    @endcan
                </x-slot>

                <x-input.group label="Assign roles">
                    <button class="inline-flex items-center mb-2 px-2.5 py-0.5 rounded-md text-sm font-medium leading-5 bg-blue-50 border border-blue-200 text-blue-800 transition ease-in-out duration-150 hover:bg-blue-100">
                        Add role
                        @icon('add', 'h-4 w-4 text-blue-700 ml-1')
                    </button>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Update User</button>

                <a href="{{ route('users.index', "status={$user->state}") }}" class="button">Cancel</a>
            </x-form.footer>
        </form>
    </x-panel>
@endsection
