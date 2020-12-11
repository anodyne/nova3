@extends($__novaStructure)

@section('layout')
<div
    x-data="{ sidebarOpen: false }"
    x-on:keydown.window.escape="sidebarOpen = false"
    class="h-screen flex overflow-hidden bg-gray-100"
>
    <div
        x-show="sidebarOpen"
        x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state."
        x-cloak
        class="md:hidden"
    >
        <div class="fixed inset-0 flex z-40">
            <div
                x-on:click="sidebarOpen = false"
                x-show="sidebarOpen"
                x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state."
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-cloak
                class="fixed inset-0"
                aria-hidden="true"
            >
                <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
            </div>

            <div
                x-show="sidebarOpen"
                x-description="Off-canvas menu, show/hide based on off-canvas menu state."
                x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                x-cloak
                class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-white"
            >
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button
                        x-show="sidebarOpen"
                        x-on:click="sidebarOpen = false"
                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        x-cloak
                    >
                        <span class="sr-only">Close sidebar</span>
                        @icon('close', 'h-6 w-6 text-white')
                    </button>
                </div>

                <div class="flex-shrink-0 flex items-center px-4">
                    <x-nova-logo class="h-8 w-auto text-blue-500" />
                </div>

                <div class="mt-5 flex-1 h-0 overflow-y-auto">
                    <nav class="px-2 space-y-1">
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-base font-semibold rounded-md transition ease-in-out duration-150 @if (request()->routeIs('dashboard')) text-gray-900 bg-gray-100 @else text-gray-600 hover:text-gray-900 hover:bg-gray-50 @endif">
                            @icon('dashboard', 'mr-4 h-6 w-6 text-gray-500 group-hover:text-gray-500 group-focus:text-gray-600 transition ease-in-out duration-150')
                            Dashboard
                        </a>

                        <a href="{{ route('notes.index') }}" class="group flex items-center px-2 py-2 text-base font-semibold rounded-md transition ease-in-out duration-150 @if (request()->routeIs('notes.*')) text-gray-900 bg-gray-100 @else text-gray-600 hover:text-gray-900 hover:bg-gray-50 @endif">
                            @icon('note', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 transition ease-in-out duration-150')
                            My Notes
                        </a>

                        @can('create', 'Nova\Posts\Models\Post')
                            <a href="{{ route('posts.create') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md transition ease-in-out duration-150 @if (request()->routeIs('posts.create') || request()->routeIs('posts.compose')) text-gray-900 bg-gray-100 @else text-gray-600 hover:text-gray-900 hover:bg-gray-50 @endif">
                                @icon('write', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 transition ease-in-out duration-150')
                                Write New Post
                            </a>
                        @endcan

                        <div class="group flex items-center px-2 py-2 text-base font-semibold rounded-md transition ease-in-out duration-150 @if (request()->routeIs('stories.*') || request()->routeIs('post-types.*')) text-gray-900 bg-gray-100 @else text-gray-600 hover:text-gray-900 hover:bg-gray-50 @endif">
                            @icon('book', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 transition ease-in-out duration-150')
                            Stories
                        </div>
                        <div class="flex flex-col ml-12 space-y-2">
                            @can('viewAny', 'Nova\Stories\Models\Story')
                                <a href="{{ route('stories.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('stories.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Stories</a>
                            @endcan

                            @can('viewAny', 'Nova\PostTypes\Models\PostType')
                                <a href="{{ route('post-types.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('post-types.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Post Types</a>
                            @endcan
                        </div>

                        @if (auth()->user()->canManage())
                            <div class="group flex items-center px-2 py-2 text-base font-semibold rounded-md transition ease-in-out duration-150 @if (request()->routeIs('characters.*') || request()->routeIs('departments.*') || request()->routeIs('positions.*') || request()->routeIs('ranks.*') || request()->routeIs('roles.*') || request()->routeIs('settings.*') || request()->routeIs('users.*')) text-gray-900 bg-gray-100 @else text-gray-600 hover:text-gray-900 hover:bg-gray-50 @endif">
                                @icon('settings', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 transition ease-in-out duration-150')
                                Manage
                            </div>
                            <div class="flex flex-col ml-12 space-y-2">
                                @can('viewAny', 'Nova\Characters\Models\Character')
                                    <a href="{{ route('characters.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('characters.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Characters</a>
                                @endcan

                                @can('viewAny', 'Nova\Departments\Models\Department')
                                    <a href="{{ route('departments.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('departments.*') || request()->routeIs('positions.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Departments</a>
                                @endcan

                                @can('viewAny', 'Nova\Ranks\Models\RankItem')
                                    <a href="{{ route('ranks.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('ranks.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Ranks</a>
                                @endcan

                                @can('viewAny', 'Nova\Roles\Models\Role')
                                    <a href="{{ route('roles.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('roles.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Roles</a>
                                @endcan

                                @can('viewAny', 'Nova\Settings\Models\Settings')
                                    <a href="{{ route('settings.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('settings.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Settings</a>
                                @endcan

                                @can('viewAny', 'Nova\Themes\Models\Theme')
                                    <a href="{{ route('themes.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('themes.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Themes</a>
                                @endcan

                                @can('viewAny', 'Nova\Users\Models\User')
                                    <a href="{{ route('users.index', 'status=active') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('users.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Users</a>
                                @endcan
                            </div>
                        @endif
                    </nav>
                </div>
            </div>

            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden | md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64">
            <div class="flex flex-col flex-grow border-r border-gray-200 pt-5 pb-4 bg-white overflow-y-auto">
                <div class="flex items-center flex-shrink-0 px-4">
                    <x-nova-logo class="h-8 w-auto text-blue-500" />
                </div>

                <div class="mt-5 flex-grow flex flex-col">
                    <!-- Sidebar component, swap this element with another sidebar if you like -->
                    <nav class="flex-1 px-2 bg-white space-y-1">
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-semibold rounded-md transition ease-in-out duration-150 @if (request()->routeIs('dashboard')) text-gray-900 bg-gray-100 @else text-gray-500 hover:text-gray-700 hover:bg-gray-50 @endif">
                            @icon('dashboard', 'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 transition ease-in-out duration-150')
                            Dashboard
                        </a>
                        <a href="{{ route('notes.index') }}" class="group flex items-center px-2 py-2 text-sm font-semibold rounded-md transition ease-in-out duration-150 @if (request()->routeIs('notes.*')) text-gray-900 bg-gray-100 @else text-gray-500 hover:text-gray-700 hover:bg-gray-50 @endif">
                            @icon('note', 'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 transition ease-in-out duration-150')
                            My Notes
                        </a>

                        @can('create', 'Nova\Posts\Models\Post')
                            <a href="{{ route('posts.create') }}" class="group flex items-center px-2 py-2 text-sm font-semibold rounded-md transition ease-in-out duration-150 @if (request()->routeIs('posts.create') || request()->routeIs('posts.compose')) text-gray-900 bg-gray-100 @else text-gray-500 hover:text-gray-700 hover:bg-gray-50 @endif">
                                @icon('write', 'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 transition ease-in-out duration-150')
                                Write New Post
                            </a>
                        @endcan

                        <div class="group flex items-center px-2 py-2 text-sm font-semibold rounded-md transition ease-in-out duration-150 @if (request()->routeIs('stories.*') || request()->routeIs('post-types.*')) text-gray-900 bg-gray-100 @else text-gray-500 hover:text-gray-700 hover:bg-gray-50 @endif">
                            @icon('book', 'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 transition ease-in-out duration-150')
                            Stories
                        </div>
                        <div class="flex flex-col text-sm ml-11 space-y-2">
                            @can('viewAny', 'Nova\Stories\Models\Story')
                                <a href="{{ route('stories.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('stories.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Stories</a>
                            @endcan

                            @can('viewAny', 'Nova\PostTypes\Models\PostType')
                                <a href="{{ route('post-types.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('post-types.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Post Types</a>
                            @endcan
                        </div>

                        @if (auth()->user()->canManage())
                            <div class="group flex items-center px-2 py-2 text-sm font-semibold rounded-md transition ease-in-out duration-150 @if (request()->routeIs('characters.*') || request()->routeIs('departments.*') || request()->routeIs('positions.*') || request()->routeIs('ranks.*') || request()->routeIs('roles.*') || request()->routeIs('settings.*') || request()->routeIs('users.*'))  text-gray-900 bg-gray-100 @else text-gray-500 hover:text-gray-700 hover:bg-gray-50 @endif">
                                @icon('settings', 'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 transition ease-in-out duration-150')
                                Manage
                            </div>
                            <div class="flex flex-col text-sm ml-11 space-y-2">
                                @can('viewAny', 'Nova\Characters\Models\Character')
                                    <a href="{{ route('characters.index', 'status=active') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('characters.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Characters</a>
                                @endcan

                                @can('viewAny', 'Nova\Departments\Models\Department')
                                    <a href="{{ route('departments.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('departments.*') || request()->routeIs('positions.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Departments</a>
                                @endcan

                                @can('viewAny', 'Nova\Ranks\Models\RankItem')
                                    <a href="{{ route('ranks.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('ranks.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Ranks</a>
                                @endcan

                                @can('viewAny', 'Nova\Roles\Models\Role')
                                    <a href="{{ route('roles.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('roles.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Roles</a>
                                @endcan

                                @can('viewAny', 'Nova\Settings\Models\Settings')
                                    <a href="{{ route('settings.index', 'general') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('settings.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Settings</a>
                                @endcan

                                @can('viewAny', 'Nova\Themes\Models\Theme')
                                    <a href="{{ route('themes.index') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('themes.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Themes</a>
                                @endcan

                                @can('viewAny', 'Nova\Users\Models\User')
                                    <a href="{{ route('users.index', 'status=active') }}" class="font-medium transition ease-in-out duration-150 @if (request()->routeIs('users.*')) text-gray-900 @else text-gray-500 hover:text-gray-700 @endif">Users</a>
                                @endcan
                            </div>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
            <button
                x-on:click.stop="sidebarOpen = true"
                class="px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 | md:hidden"
            >
                <span class="sr-only">Open sidebar</span>
                @icon('menu', 'h-6 w-6')
            </button>

            <div class="flex-1 px-4 flex justify-between">
                <div class="flex-1 flex">
                    <form class="w-full flex | md:ml-0" action="#" method="GET">
                        <label for="search_field" class="sr-only">Search</label>
                        <div class="relative flex items-center w-full text-gray-400 focus-within:text-gray-600">
                            <div class="flex items-center pointer-events-none">
                                @icon('search', 'h-6 w-6')
                            </div>
                            <input id="search_field" class="block w-full h-full px-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent" placeholder="Search" type="search" name="search">
                        </div>
                    </form>
                </div>

                <div class="ml-4 flex items-center space-x-4 | md:ml-6">
                    @livewire('users:notifications')

                    <x-dropdown placement="bottom-end">
                        <x-slot name="trigger">
                            <x-avatar size="xs" :src="auth()->user()->avatar_url" :tooltip="auth()->user()->name" />
                        </x-slot>

                        <x-dropdown.group>
                            <x-dropdown.item type="submit" icon="sign-out" form="logout-form">
                                <span>Sign out</span>

                                <x-slot name="buttonForm">
                                    <x-form :action="route('logout')" class="hidden" id="logout-form" />
                                </x-slot>
                            </x-dropdown.item>
                        </x-dropdown.group>

                    </x-dropdown>
                </div>
            </div>
        </div>

        <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none" tabindex="0">
            <div class="py-6">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 md:px-8">
                    @yield('template')
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
