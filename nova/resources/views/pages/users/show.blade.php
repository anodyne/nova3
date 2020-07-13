@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$user->name">
        <x-slot name="pretitle">
            <a href="{{ route('users.index', "status={$user->status->name()}") }}">Users</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $user)
                <a href="{{ route('users.edit', $user) }}" class="button button-primary">Edit User</a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form.section title="User Info" message="For privacy reasons, users are encouraged to use a nickname instead of their real name. Additionally, user email addresses should be safeguarded at all costs and not shared with other players without the express permission of this user.">
            <x-input.group label="Name">
                <p class="font-semibold">{{ $user->name }}</p>
            </x-input.group>

            <x-input.group label="Email address">
                <p class="font-semibold">{{ $user->email }}</p>
            </x-input.group>

            <x-input.group label="Preferred pronouns">
                <p class="font-semibold">{{ $user->pronouns }}</p>
            </x-input.group>

            <x-input.group label="Status">
                <x-badge :type="$user->status->color()">{{ $user->status->displayName() }}</x-badge>
            </x-input.group>

            <x-input.group label="Avatar">
                <x-avatar :url="$user->avatar_url" size="lg" />
            </x-input.group>
        </x-form.section>

        <x-form.section title="Character(s)">
            <div class="flex flex-col w-full space-y-2">
                @foreach ($user->characters as $character)
                    <div class="group flex items-center justify-between w-full py-2 px-4 rounded odd:bg-gray-100">
                        <div class="flex items-center space-x-3">
                            <x-avatar-meta size="lg" :url="$character->avatar_url">
                                <x-slot name="primaryMeta">
                                    <x-status :status="$character->status" />
                                    <span class="ml-2">{{ $character->name }}</span>
                                </x-slot>

                                <x-slot name="secondaryMeta">
                                    <x-badge :type="$character->type->color()" size="sm">{{ $character->type->displayName() }}</x-badge>
                                </x-slot>
                            </x-avatar-meta>
                        </div>

                        @can('update', $character)
                            <a href="{{ route('characters.edit', $character) }}" class="text-gray-500 transition ease-in-out duration-150 hover:text-gray-700 group-hover:visible | sm:invisible">
                                @icon('edit')
                            </a>
                        @endcan
                    </div>
                @endforeach
            </div>
        </x-form.section>

        <x-form.section title="Activity" message="Keep track of milestones and latest activity of a user in the system.">
            <x-input.group label="Joined">
                <p class="font-semibold">{{ $user->created_at }}</p>
            </x-input.group>

            <x-input.group label="Last update">
                <p class="font-semibold">{{ $user->updated_at }}</p>
            </x-input.group>

            <x-input.group label="Last sign in">
                <p class="font-semibold"></p>
            </x-input.group>
        </x-form.section>

        <x-form.section title="Roles" message="Roles are the actions a user can take.">
            <x-input.group>
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
            </x-input.group>
        </x-form.section>

        <x-form.footer>
            <a href="{{ route('users.index', "status={$user->status->name()}") }}" class="button">Back</a>
        </x-form.footer>
    </x-panel>
@endsection
