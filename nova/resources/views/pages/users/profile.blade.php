@extends($meta->template)

@section('content')
    <a
        href="{{ route('users.index', "status={$user->status->name()}") }}"
        class="group mb-4 inline-flex items-center text-sm font-medium text-gray-600 transition duration-200 ease-in-out hover:text-gray-800"
    >
        <x-icon.chevron-left
            class="h-5 w-5 text-gray-400 transition duration-200 ease-in-out group-hover:text-gray-500"
        />
        <span class="ml-1">Back to Users</span>
    </a>

    <x-panel class="p-4 sm:p-6">
        <div class="flex">
            <div>
                <x-avatar :src="$user->avatar_url" size="xl" />
            </div>
            <div class="ml-6 flex flex-col">
                <x-h1>{{ $user->name }}</x-h1>

                <div class="mt-1 flex items-center space-x-8 text-sm text-gray-500">
                    <div class="flex items-center leading-0">
                        <x-icon name="mail" size="sm" class="text-gray-400"></x-icon>
                        <span class="ml-2">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center leading-0">
                        <x-icon name="clock" size="sm" class="text-gray-400"></x-icon>
                        <span class="ml-2">Last activity</span>
                    </div>
                    <div class="flex items-center leading-0">
                        <x-icon name="login" size="sm" class="text-gray-400"></x-icon>
                        <span class="ml-2">Last sign in</span>
                    </div>
                </div>
            </div>
        </div>
    </x-panel>

    <ul class="my-8 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
        @foreach ($user->characters as $character)
            <li class="col-span-1 flex flex-col rounded-lg bg-white text-center shadow">
                <div class="flex flex-1 flex-col p-8">
                    <div>
                        <x-avatar :src="$character->avatar_url" size="xl" />
                    </div>
                    <h3 class="mt-6 text-sm font-medium text-gray-900">
                        @isset($character->rank)
                            {{ $character->rank->name->name }}
                        @endisset

                        {{ $character->name }}
                    </h3>
                    <dl class="mt-1 flex grow flex-col justify-between">
                        <dt class="sr-only">Title</dt>
                        <dd class="text-sm text-gray-500">{{ $character->positions->implode('name', ' & ') }}</dd>

                        <dt class="sr-only">Role</dt>
                        <dd class="mt-3 space-x-3">
                            <x-badge :color="$character->status->color()">
                                {{ $character->status->displayName() }}
                            </x-badge>
                            <x-badge :color="$character->type->color()">
                                {{ $character->type->displayName() }}
                            </x-badge>
                        </dd>
                    </dl>
                </div>
                {{--
                    <div class="border-t border-gray-200">
                    <div class="-mt-px flex">
                    <div class="w-0 flex-1 flex border-r border-gray-200">
                    <a href="#" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500 focus:outline-none focus:ring focus:border-primary-400 focus:z-10 transition ease-in-out duration-200">
                    <x-icon name="show" size="sm" class="text-gray-400"></x-icon>
                    <span class="ml-3">View</span>
                    </a>
                    </div>
                    <div class="-ml-px w-0 flex-1 flex">
                    <a href="#" class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500 focus:outline-none focus:ring focus:border-primary-400 focus:z-10 transition ease-in-out duration-200">
                    <x-icon name="edit" size="sm" class="text-gray-400"></x-icon>
                    <span class="ml-3">Edit</span>
                    </a>
                    </div>
                    </div>
                    </div>
                --}}
            </li>
        @endforeach
    </ul>

    <x-panel>
        <div class="pb-8">
            <div class="p-4 sm:hidden">
                <select
                    @change="window.location.replace($event.target.value)"
                    aria-label="Selected tab"
                    class="form-select mt-1 block w-full border-gray-300 bg-white py-2 pl-3 pr-10 text-base transition duration-200 ease-in-out focus:border-primary-400 focus:outline-none focus:ring sm:text-sm"
                >
                    <option
                        value="{{ route('users.index', 'status=active') }}"
                        @selected(request()->status === 'active')
                    >
                        Active Users
                    </option>
                    <option
                        value="{{ route('users.index', 'status=pending') }}"
                        @selected(request()->status === 'pending')
                    >
                        Pending Users
                    </option>
                    <option
                        value="{{ route('users.index', 'status=inactive') }}"
                        @selected(request()->status === 'inactive')
                    >
                        Inactive Users
                    </option>
                    <option value="{{ route('users.index') }}" @selected(! request()->has('status'))>
                        All Users
                    </option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200 px-4 sm:px-6">
                    <nav class="-mb-px flex">
                        <a
                            href="{{ route('users.index', 'status=active') }}"
                            class="@if (request()->status === 'active') border-primary-300 text-primary-500 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif ml-8 whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium first:ml-0 focus:outline-none"
                        >
                            Basic Info
                        </a>
                        <a
                            href="{{ route('users.index', 'status=pending') }}"
                            class="@if (request()->status === 'pending') border-primary-300 text-primary-500 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif ml-8 whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium first:ml-0 focus:outline-none"
                        >
                            Activity
                        </a>
                        <a
                            href="{{ route('users.index', 'status=inactive') }}"
                            class="@if (request()->status === 'inactive') border-primary-300 text-primary-500 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif ml-8 whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium first:ml-0 focus:outline-none"
                        >
                            Foo
                        </a>
                        <a
                            href="{{ route('users.index') }}"
                            class="@if (!request()->has('status')) border-primary-300 text-primary-500 @else text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif ml-8 whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium first:ml-0 focus:outline-none"
                        >
                            Bar
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </x-panel>

    {{--
        <x-page-header :title="$user->name">
        <x-slot:pretitle>
        <a href="{{ route('users.index', "status={$user->status->name()}") }}">Users</a>
        </x-slot:pretitle>
        
        <x-slot:actions>
        @can('update', $user)
        <x-button.filled :href="route('users.edit', $user)" color="primary">Edit User</x-button.filled>
        @endcan
        </x-slot:actions>
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
        <div class="flex items-center font-semibold text-warning-600">
        <x-icon name="warning" size="md" class="mr-3 shrink-0"></x-icon>
        <span>This user does not have any roles.</span>
        </div>
        @endforelse
        </div>
        </x-input.group>
        </x-form.section>
        
        <x-form.footer>
        <x-button.filled :href='route("users.index", "status={$user->status->name()}")' color="neutral">Back</x-button.filled>
        </x-form.footer>
        </x-panel>
    --}}
@endsection
