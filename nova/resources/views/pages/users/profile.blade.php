@extends($__novaTemplate)

@section('content')
    <a href="{{ route('users.index', "status={$user->status->name()}") }}" class="group inline-flex items-center mb-4 text-sm text-gray-600 font-medium transition ease-in-out duration-150 hover:text-gray-800">
        @icon('chevron-left', 'h-5 w-5 text-gray-400 transition ease-in-out duration-150 group-hover:text-gray-500')
        <span class="ml-1">Back to Users</span>
    </a>

    <x-panel class="p-4 | sm:p-6">
        <div class="flex">
            <div>
                <x-avatar :src="$user->avatar_url" size="xl" />
            </div>
            <div class="flex flex-col ml-6">
                <h1 class="block text-2xl font-extrabold text-gray-900 | sm:text-4xl sm:truncate">
                    {{ $user->name }}
                </h1>

                <div class="flex items-center text-gray-500 text-sm mt-1 space-x-8">
                    <div class="flex items-center leading-0">
                        @icon('email', 'text-gray-400')
                        <span class="ml-2">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center leading-0">
                        @icon('clock', 'text-gray-400')
                        <span class="ml-2">Last activity</span>
                    </div>
                    <div class="flex items-center leading-0">
                        @icon('sign-out', 'text-gray-400')
                        <span class="ml-2">Last sign in</span>
                    </div>
                </div>
            </div>
        </div>
    </x-panel>

    <ul class="my-8 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
        @foreach ($user->characters as $character)
            <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow">
                <div class="flex-1 flex flex-col p-8">
                    <div>
                        <x-avatar :src="$character->avatar_url" size="xl" />
                    </div>
                    <h3 class="mt-6 text-gray-900 text-sm font-medium">
                        @isset($character->rank)
                            {{ $character->rank->name->name }}
                        @endisset
                        {{ $character->name }}
                    </h3>
                    <dl class="mt-1 flex-grow flex flex-col justify-between">
                        <dt class="sr-only">Title</dt>
                        <dd class="text-gray-500 text-sm">{{ $character->positions->implode('name', ' & ') }}</dd>

                        <dt class="sr-only">Role</dt>
                        <dd class="mt-3 space-x-3">
                            <x-badge size="xs" :color="$character->status->color()">{{ $character->status->displayName() }}</x-badge>
                            <x-badge size="xs" :color="$character->type->color()">{{ $character->type->displayName() }}</x-badge>
                        </dd>
                    </dl>
                </div>
                {{-- <div class="border-t border-gray-200">
                    <div class="-mt-px flex">
                        <div class="w-0 flex-1 flex border-r border-gray-200">
                            <a href="#" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500 focus:outline-none focus:ring focus:border-blue-7 focus:z-10 transition ease-in-out duration-150">
                                @icon('show', 'w-5 h-5 text-gray-400')
                                <span class="ml-3">View</span>
                            </a>
                        </div>
                        <div class="-ml-px w-0 flex-1 flex">
                            <a href="#" class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500 focus:outline-none focus:ring focus:border-blue-7 focus:z-10 transition ease-in-out duration-150">
                                @icon('edit', 'w-5 h-5 text-gray-400')
                                <span class="ml-3">Edit</span>
                            </a>
                        </div>
                    </div>
                </div> --}}
            </li>
        @endforeach
    </ul>

    <x-panel>
        <div class="pb-8">
            <div class="p-4 | sm:hidden">
                <select x-on:change="window.location.replace($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring focus:border-blue-7 sm:text-sm transition ease-in-out duration-150">
                    <option value="{{ route('users.index', 'status=active') }}"{{ request()->status === 'active' ? 'selected' : '' }}>Active Users</option>
                    <option value="{{ route('users.index', 'status=pending') }}"{{ request()->status === 'pending' ? 'selected' : '' }}>Pending Users</option>
                    <option value="{{ route('users.index', 'status=inactive') }}"{{ request()->status === 'inactive' ? 'selected' : '' }}>Inactive Users</option>
                    <option value="{{ route('users.index') }}"{{ !request()->has('status') ? 'selected' : '' }}>All Users</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200 px-4 | sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            href="{{ route('users.index', 'status=active') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none @if (request()->status === 'active') border-blue-6 text-blue-9 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            Basic Info
                        </a>
                        <a
                            href="{{ route('users.index', 'status=pending') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none @if (request()->status === 'pending') border-blue-6 text-blue-9 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            Activity
                        </a>
                        <a
                            href="{{ route('users.index', 'status=inactive') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none @if (request()->status === 'inactive') border-blue-6 text-blue-9 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            Foo
                        </a>
                        <a
                            href="{{ route('users.index') }}"
                            class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none @if (!request()->has('status')) border-blue-6 text-blue-9 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                        >
                            Bar
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </x-panel>

    {{-- <x-page-header :title="$user->name">
        <x-slot name="pretitle">
            <a href="{{ route('users.index', "status={$user->status->name()}") }}">Users</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $user)
                <x-button-link :href="route('users.edit', $user)" color="blue">Edit User</x-button-link>
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

            <x-input.group label="Avatar">
                <x-avatar :src="$user->avatar_url" size="lg"></x-avatar>
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
                        <div class="flex items-center font-semibold text-yellow-11">
                            @icon('warning', 'mr-3 flex-shrink-0 h-6 w-6')
                            <span>This user does not have any roles.</span>
                        </div>
                    @endforelse
                </div>
            </x-input.group>
        </x-form.section>

        <x-form.footer>
            <x-button-link :href='route("users.index", "status={$user->status->name()}")' color="white">Back</x-button-link>
        </x-form.footer>
    </x-panel> --}}
@endsection
