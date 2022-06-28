@extends($meta->template)

@section('content')
    <x-page-header :title="$user->name">
        <x-slot:pretitle>
            <a href="{{ route('users.index', "status={$user->status->name()}") }}">Users</a>
        </x-slot:pretitle>

        <x-slot:controls>
            @can('update', $user)
                <x-link :href="route('users.edit', $user)" color="primary">Edit User</x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    <x-panel>
        <x-form action="">
            <x-form.section title="User Info" message="For privacy reasons, users are encouraged to use a nickname instead of their real name. Additionally, user email addresses should be safeguarded at all costs and not shared with other players without the express permission of this user.">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $user->name }}</p>
                </x-input.group>

                <x-input.group label="Email address">
                    <p class="font-semibold">{{ $user->email }}</p>
                </x-input.group>

                @if ($user->pronouns->value !== null)
                    <x-input.group label="Pronouns">
                        <div class="inline-flex items-center space-x-1">
                            <p class="font-semibold">{{ $user->pronouns->subject }}</p>
                            <p class="text-gray-500">/</p>
                            <p class="font-semibold">{{ $user->pronouns->object }}</p>
                            <p class="text-gray-500">/</p>
                            <p class="font-semibold">{{ $user->pronouns->possessive }}</p>
                        </div>
                    </x-input.group>
                @endif

                <x-input.group label="Status">
                    <x-badge :color="$user->status->color()">{{ $user->status->displayName() }}</x-badge>
                </x-input.group>

                <x-input.group label="Avatar">
                    <x-avatar :src="$user->avatar_url" size="lg" />
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

            <x-form.footer>
                <x-link :href='route("users.index", "status={$user->status->name()}")' color="white">Back</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
