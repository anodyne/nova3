@extends($__novaStructure)

@section('layout')
<div
    x-data="{ sidebarOpen: false }"
    x-on:keydown.window.escape="sidebarOpen = false"
    class="h-screen flex overflow-hidden bg-gray-100"
>
    <!-- Off-canvas menu for mobile -->
    <div x-show="sidebarOpen" class="md:hidden" x-cloak>
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
                class="fixed inset-0"
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
                class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-white"
            >
                <div class="absolute top-0 right-0 -mr-14 p-1">
                    <button
                        x-show="sidebarOpen"
                        x-on:click="sidebarOpen = false"
                        class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600"
                        aria-label="Close sidebar"
                    >
                        @icon('close', 'h-6 w-6 text-white')
                    </button>
                </div>

                <div class="flex-shrink-0 flex items-center px-4">
                    <x-nova-logo class="h-8 w-auto text-blue-500" />
                </div>

                <div class="mt-5 flex-1 h-0 overflow-y-auto">
                    <nav class="px-2">
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-base leading-6 font-medium text-gray-900 rounded-md bg-gray-100 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150">
                            @icon('dashboard', 'mr-4 h-6 w-6 text-gray-500 group-hover:text-gray-500 group-focus:text-gray-600 transition ease-in-out duration-150')
                            Dashboard
                        </a>
                        <a href="{{ route('notes.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                            @icon('book', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                            My Notes
                        </a>
                        {{-- <a href="{{ route('notes.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                            @icon('users', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                            Players
                        </a> --}}

                        @if (auth()->user()->canManage())
                            <div class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                                @icon('settings', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                                Manage
                            </div>
                            <div class="flex flex-col ml-12">
                                @can('viewAny', 'Nova\Characters\Models\Character')
                                    <a href="{{ route('departments.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Characters</a>
                                @endcan

                                @can('viewAny', 'Nova\Departments\Models\Department')
                                    <a href="{{ route('departments.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Departments</a>
                                @endcan

                                @can('viewAny', 'Nova\Ranks\Models\RankItem')
                                    <a href="{{ route('ranks.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Ranks</a>
                                @endcan

                                @can('viewAny', 'Nova\Roles\Models\Role')
                                    <a href="{{ route('roles.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Roles</a>
                                @endcan

                                @can('viewAny', 'Nova\Settings\Models\Settings')
                                    <a href="{{ route('settings.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Settings</a>
                                @endcan

                                @can('viewAny', 'Nova\Themes\Models\Theme')
                                    <a href="{{ route('themes.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Themes</a>
                                @endcan

                                @can('viewAny', 'Nova\Users\Models\User')
                                    <a href="{{ route('users.index', 'status=active') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Users</a>
                                @endcan
                            </div>
                        @endif
                    </nav>
                </div>
            </div>
            <div class="flex-shrink-0 w-14">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden | md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64 border-r border-gray-200 pt-5 pb-4 bg-white">
            <div class="flex items-center flex-shrink-0 px-4">
                <x-nova-logo class="h-8 w-auto text-blue-500" />
            </div>

            <div class="mt-5 h-0 flex-1 flex flex-col overflow-y-auto">
                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <nav class="flex-1 px-2 bg-white">
                    <a href="{{ route('dashboard') }}" class="mt-1 first:mt-0 group flex items-center px-2 py-2 text-sm leading-5 font-semibold text-gray-500 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                        @icon('dashboard', 'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                        Dashboard
                    </a>
                    <a href="{{ route('notes.index') }}" class="mt-1 first:mt-0 group flex items-center px-2 py-2 text-sm leading-5 font-semibold text-gray-500 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                        @icon('book', 'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                        My Notes
                    </a>
                    {{-- <a href="{{ route('notes.index') }}" class="mt-1 first:mt-0 group flex items-center px-2 py-2 text-sm leading-5 font-semibold text-gray-500 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                        @icon('users', 'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                        Players
                    </a> --}}

                    @if (auth()->user()->canManage())
                        <div class="mt-1 first:mt-0 group flex items-center px-2 py-2 text-sm leading-5 font-semibold text-gray-500 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                            @icon('settings', 'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                            Manage
                        </div>
                        <div class="flex flex-col text-sm ml-11">
                            @can('viewAny', 'Nova\Characters\Models\Character')
                                <a href="{{ route('characters.index', 'status=active') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Characters</a>
                            @endcan

                            @can('viewAny', 'Nova\Departments\Models\Department')
                                <a href="{{ route('departments.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Departments</a>
                            @endcan

                            @can('viewAny', 'Nova\Ranks\Models\RankItem')
                                <a href="{{ route('ranks.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Ranks</a>
                            @endcan

                            @can('viewAny', 'Nova\Roles\Models\Role')
                                <a href="{{ route('roles.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Roles</a>
                            @endcan

                            @can('viewAny', 'Nova\Settings\Models\Settings')
                                <a href="{{ route('settings.index', 'general') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Settings</a>
                            @endcan

                            @can('viewAny', 'Nova\Themes\Models\Theme')
                                <a href="{{ route('themes.index') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Themes</a>
                            @endcan

                            @can('viewAny', 'Nova\Users\Models\User')
                                <a href="{{ route('users.index', 'status=active') }}" class="my-1 font-medium text-gray-500 hover:text-gray-700 transition ease-in-out duration-150">Users</a>
                            @endcan
                        </div>
                    @endif
                </nav>
            </div>
        </div>
    </div>

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
            <button
                x-on:click.stop="sidebarOpen = true"
                class="px-4 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 | md:hidden"
                aria-label="Open sidebar"
            >
                @icon('menu', 'h-6 w-6')
            </button>

            <div class="flex-1 px-4 flex justify-between">
                <div class="flex-1 flex">
                    <div class="w-full flex | md:ml-0">
                        <label for="search_field" class="sr-only">Search</label>
                        <div class="flex items-center relative w-full text-gray-400 focus-within:text-gray-600">
                            <div class="flex-shrink-0 mr-2 pointer-events-none leading-0">
                                @icon('search', 'h-6 w-6')
                            </div>

                            <input
                                id="search_field"
                                class="block w-full h-full pr-3 py-2 text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400"
                                placeholder="Search"
                                type="search"
                            >
                        </div>
                    </div>
                </div>

                <div class="ml-4 flex items-center | md:ml-6">
                    @livewire('users:notifications')

                    <x-dropdown placement="bottom-end" class="ml-4">
                        <x-avatar size="xs" :url="auth()->user()->avatar_url" :tooltip="auth()->user()->name" />

                        <x-slot name="dropdown">
                            <button class="{{ $component->link() }}" form="logout-form" role="menuitem">
                                @icon('sign-out', $component->icon())
                                <span>Sign out</span>
                            </button>

                            <x-form :action="route('logout')" class="hidden" id="logout-form" />
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>

        <main class="flex-1 relative z-0 overflow-y-auto py-6 focus:outline-none" tabindex="0">
            <div class="max-w-5xl mx-auto px-4 | sm:px-6 md:px-8">
                @yield('template')
            </div>
        </main>
    </div>
</div>
@endsection
