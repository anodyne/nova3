@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$user->name">
        <x-slot name="pretitle">
            <a href="{{ route('users.index', "status={$user->status->name()}") }}">Users</a>
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

            <x-input.group label="Avatar">
                <x-avatar :url="$user->avatar_url" size="lg"></x-avatar>
            </x-input.group>
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
