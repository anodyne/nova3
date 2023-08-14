@extends($meta->structure)

@php($settings = settings())

@section('layout')
    @impersonating
    <div class="fixed z-50 flex w-full items-center justify-between gap-x-6 bg-gray-900 px-6 py-2.5 sm:pr-3.5 lg:pl-8">
        <p class="text-sm leading-6 text-white">
            <a href="#">
                <strong class="font-semibold">Impersonation mode</strong>
                <svg viewBox="0 0 2 2" class="mx-2 inline h-0.5 w-0.5 fill-current" aria-hidden="true">
                    <circle cx="1" cy="1" r="1" />
                </svg>
                You are currently impersonating {{ auth()->user()->name }}
            </a>
        </p>
        <a
            href="{{ route('impersonate.leave') }}"
            class="group -m-3 flex items-center p-3 focus-visible:outline-offset-[-4px]"
        >
            <span class="mr-2 hidden text-sm font-medium text-gray-300 group-hover:block">Leave impersonation</span>
            <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path
                    d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"
                />
            </svg>
        </a>
    </div>
    @endImpersonating

    <div x-data="{ open: false }" class="relative min-h-screen xl:flex xl:py-3">
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <div class="relative z-50 xl:hidden" role="dialog" aria-modal="true" x-show="open" x-cloak>
            <div
                x-show="open"
                x-transition:enter="transition-opacity duration-300 ease-linear"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-300 ease-linear"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/80"
                x-description="Off-canvas menu backdrop, show/hide based on off-canvas menu state."
                class="fixed inset-0 bg-gray-900/80"
                x-cloak
            ></div>
            <div class="fixed inset-0 flex">
                <div
                    x-show="open"
                    x-transition:enter="transform transition duration-300 ease-in-out"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition duration-300 ease-in-out"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    x-description="Off-canvas menu, show/hide based on off-canvas menu state."
                    class="relative mr-16 flex w-full max-w-xs flex-1"
                    x-on:click.away="open = false"
                    x-cloak
                >
                    <div
                        x-show="open"
                        x-transition:enter="duration-300 ease-in-out"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="duration-300 ease-in-out"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        x-description="Close button, show/hide based on off-canvas menu state."
                        class="absolute left-full top-0 flex w-16 justify-center pt-5"
                        x-cloak
                    >
                        <button type="button" class="-m-2.5 p-2.5" x-on:click="open = false">
                            <span class="sr-only">Close sidebar</span>
                            <svg
                                class="h-6 w-6 text-white"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Sidebar component, swap this element with another sidebar if you like -->
                    <div class="dark flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 ring-1 ring-white/10">
                        <div class="flex h-16 shrink-0 items-center">
                            <a href="{{ route('dashboard') }}">
                                @if (app('nova.settings')->getFirstMedia('logo'))
                                    <img
                                        src="{{ app('nova.settings')->getFirstMediaUrl('logo') }}"
                                        alt="logo"
                                        class="block h-8 w-auto"
                                    />
                                @else
                                    <x-logos.nova class="h-8 w-auto text-white" />
                                @endif
                            </a>
                        </div>
                        <nav class="flex flex-1 flex-col">
                            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                <li>
                                    <ul role="list" class="-mx-2 space-y-1">
                                        <li>
                                            <x-nav.main-item-mobile
                                                :href="route('dashboard')"
                                                :active="request()->routeIs('dashboard')"
                                                icon="home"
                                                :meta="$meta"
                                            >
                                                Dashboard
                                            </x-nav.main-item-mobile>
                                        </li>

                                        @if (auth()->user()->canWrite)
                                            <li>
                                                <x-nav.main-item-mobile
                                                    :href="route('writing-overview')"
                                                    :active="$meta->subnavSection === 'writing' || $meta->subnavSection === 'posting'"
                                                    icon="write"
                                                    :meta="$meta"
                                                >
                                                    Writing
                                                </x-nav.main-item-mobile>
                                            </li>
                                        @endif

                                        <li>
                                            <x-nav.main-item-mobile
                                                :href="route('notes.index')"
                                                :active="request()->routeIs('notes.*')"
                                                icon="note"
                                                :meta="$meta"
                                            >
                                                Notes
                                            </x-nav.main-item-mobile>
                                        </li>
                                        <li>
                                            <x-nav.main-item-mobile
                                                :href="route('characters.index')"
                                                :active="$meta->subnavSection === 'characters'"
                                                icon="characters"
                                                :meta="$meta"
                                            >
                                                Characters
                                            </x-nav.main-item-mobile>
                                        </li>

                                        @if (auth()->user()->canManageUsers)
                                            <li>
                                                <x-nav.main-item-mobile
                                                    :href="route('users.index')"
                                                    :active="$meta->subnavSection === 'users'"
                                                    icon="users"
                                                    :meta="$meta"
                                                >
                                                    Users
                                                </x-nav.main-item-mobile>
                                            </li>
                                        @endif

                                        @can('update', $settings)
                                            <li>
                                                <x-nav.main-item-mobile
                                                    :href="route('settings.index', 'general')"
                                                    :active="$meta->subnavSection === 'settings'"
                                                    icon="settings"
                                                    :meta="$meta"
                                                >
                                                    Settings
                                                </x-nav.main-item-mobile>
                                            </li>
                                        @endcan

                                        @if (auth()->user()->canManageSystem)
                                            <li>
                                                <x-nav.main-item-mobile
                                                    :href="route('system-overview')"
                                                    :active="$meta->subnavSection === 'system'"
                                                    icon="server"
                                                    :meta="$meta"
                                                >
                                                    System
                                                </x-nav.main-item-mobile>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                                <li class="mt-auto">
                                    <ul role="list" class="space-y-2">
                                        <li class="p-2 leading-none">
                                            <livewire:users:notifications />
                                        </li>
                                        <li class="leading-none">
                                            <x-nav.main-item-mobile href="#" icon="search" :meta="$meta">
                                                <div class="flex w-full items-center justify-between">
                                                    <span>Search</span>
                                                    <x-badge>/</x-badge>
                                                </div>
                                            </x-nav.main-item-mobile>
                                        </li>
                                        <li class="leading-none">
                                            <x-nav.main-item-mobile href="#" icon="help" :meta="$meta">
                                                Get help
                                            </x-nav.main-item-mobile>
                                        </li>
                                        <li class="p-2 leading-none">
                                            <div class="grid w-full grid-cols-3 rounded-md bg-gray-200 p-1">
                                                <div
                                                    class="flex items-center justify-center space-x-2 rounded bg-white px-3 py-1 text-xs font-medium text-gray-700 shadow ring-1 ring-gray-900/5"
                                                >
                                                    <x-icon name="sun" size="sm"></x-icon>
                                                    <span class="sr-only">Light</span>
                                                </div>
                                                <div
                                                    class="flex items-center justify-center space-x-2 rounded px-3 py-1 text-xs font-medium"
                                                >
                                                    <x-icon name="moon" size="sm"></x-icon>
                                                    <span class="sr-only">Dark</span>
                                                </div>
                                                <div
                                                    class="flex items-center justify-center space-x-2 rounded px-3 py-1 text-xs font-medium"
                                                >
                                                    <x-icon name="device-desktop" size="sm"></x-icon>
                                                    <span class="sr-only">System</span>
                                                </div>
                                            </div>
                                        </li>
                                        {{--
                                            <li class="px-6 leading-none">
                                            <livewire:users:admin-theme-toggle />
                                            </li>
                                        --}}
                                        <li class="!mt-4 border-t border-gray-900/5 px-6 py-4 leading-none">
                                            <x-dropdown placement="top-start">
                                                <x-slot name="trigger">
                                                    <x-avatar
                                                        size="xs"
                                                        :src="auth()->user()->avatar_url"
                                                        :tooltip="auth()->user()->name"
                                                    />
                                                    <span class="ml-2.5">
                                                        {{ auth()->user()->name }}
                                                    </span>
                                                </x-slot>

                                                <x-dropdown.group>
                                                    <x-dropdown.item href="#" icon="user">My account</x-dropdown.item>
                                                </x-dropdown.group>

                                                <x-dropdown.group>
                                                    <x-dropdown.item :href="route('whats-new')" icon="star">
                                                        See what's new
                                                    </x-dropdown.item>
                                                </x-dropdown.group>

                                                <x-dropdown.group>
                                                    <x-dropdown.item type="submit" icon="logout" form="logout-form">
                                                        <span>Sign out</span>

                                                        <x-slot name="buttonForm">
                                                            <x-form
                                                                :action="route('logout')"
                                                                class="hidden"
                                                                id="logout-form"
                                                            />
                                                        </x-slot>
                                                    </x-dropdown.item>
                                                </x-dropdown.group>
                                            </x-dropdown>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div
            @class([
                'hidden xl:fixed xl:inset-y-0 xl:z-10 xl:flex xl:w-72 xl:flex-col',
                'pt-11' => app('impersonate')->isImpersonating(),
            ])
        >
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto">
                <div class="flex shrink-0 items-center px-6 py-6">
                    <a href="{{ route('dashboard') }}">
                        @if (app('nova.settings')->getFirstMedia('logo'))
                            <img
                                src="{{ app('nova.settings')->getFirstMediaUrl('logo') }}"
                                alt="logo"
                                class="block h-8 w-auto"
                            />
                        @else
                            <x-logos.nova class="hidden h-10 w-auto md:block" />
                            <x-logos.nova-mark class="block h-8 w-auto md:hidden" />
                        @endif
                    </a>
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="space-y-1.5">
                                <li>
                                    <x-nav.main-item
                                        :href="route('dashboard')"
                                        :active="request()->routeIs('dashboard')"
                                        icon="home"
                                        :meta="$meta"
                                    >
                                        Dashboard
                                    </x-nav.main-item>
                                </li>

                                @if (auth()->user()->canWrite)
                                    <li>
                                        <x-nav.main-item
                                            :href="route('writing-overview')"
                                            :active="$meta->subnavSection === 'writing' || $meta->subnavSection === 'posting'"
                                            icon="write"
                                            :meta="$meta"
                                        >
                                            Writing
                                        </x-nav.main-item>
                                    </li>
                                @endif

                                <li>
                                    <x-nav.main-item
                                        :href="route('notes.index')"
                                        :active="request()->routeIs('notes.*')"
                                        icon="note"
                                        :meta="$meta"
                                    >
                                        Notes
                                    </x-nav.main-item>
                                </li>
                                <li>
                                    <x-nav.main-item
                                        :href="route('characters.index')"
                                        :active="$meta->subnavSection === 'characters'"
                                        icon="characters"
                                        :meta="$meta"
                                    >
                                        Characters
                                    </x-nav.main-item>
                                </li>

                                @if (auth()->user()->canManageUsers)
                                    <li>
                                        <x-nav.main-item
                                            :href="route('users.index')"
                                            :active="$meta->subnavSection === 'users'"
                                            icon="users"
                                            :meta="$meta"
                                        >
                                            Users
                                        </x-nav.main-item>
                                    </li>
                                @endif

                                @can('update', $settings)
                                    <li>
                                        <x-nav.main-item
                                            :href="route('settings.index', 'general')"
                                            :active="$meta->subnavSection === 'settings'"
                                            icon="settings"
                                            :meta="$meta"
                                        >
                                            Settings
                                        </x-nav.main-item>
                                    </li>
                                @endcan

                                @if (auth()->user()->canManageSystem)
                                    <li>
                                        <x-nav.main-item
                                            :href="route('system-overview')"
                                            :active="$meta->subnavSection === 'system'"
                                            icon="server"
                                            :meta="$meta"
                                        >
                                            System
                                        </x-nav.main-item>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li class="mt-auto">
                            <ul role="list" class="space-y-2">
                                <li class="px-6 leading-none">
                                    <x-panel class="mb-8">
                                        <x-content-box height="sm" width="sm" class="flex flex-col gap-3">
                                            <h3 class="text-sm/5 font-medium text-gray-900 dark:text-white">
                                                Complete your profile
                                            </h3>
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="relative h-2 w-full overflow-hidden rounded-full bg-gray-300 dark:bg-gray-600"
                                                >
                                                    <div
                                                        class="absolute inset-0 h-2 bg-primary-500 dark:bg-primary-400"
                                                        style="width: 25%"
                                                    ></div>
                                                </div>
                                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                                    25%
                                                </div>
                                            </div>
                                        </x-content-box>
                                    </x-panel>
                                </li>
                                <li class="px-6 leading-none">
                                    <livewire:users:notifications />
                                </li>
                                <li class="leading-none">
                                    <x-nav.main-item href="#" icon="search" :meta="$meta">Search</x-nav.main-item>
                                </li>
                                <li class="leading-none">
                                    <x-nav.main-item href="#" icon="help" :meta="$meta">Get help</x-nav.main-item>
                                </li>
                                {{--
                                    <li class="px-6 leading-none">
                                    
                                    <div class="grid w-full grid-cols-3 rounded-md bg-gray-200 p-1">
                                    <div
                                    class="flex items-center justify-center space-x-2 rounded bg-white px-3 py-1 text-xs font-medium text-gray-700 shadow ring-1 ring-gray-900/5"
                                    >
                                    <x-icon name="sun" size="sm"></x-icon>
                                    <span class="sr-only">Light</span>
                                    </div>
                                    <div
                                    class="flex items-center justify-center space-x-2 rounded px-3 py-1 text-xs font-medium"
                                    >
                                    <x-icon name="moon" size="sm"></x-icon>
                                    <span class="sr-only">Dark</span>
                                    </div>
                                    <div
                                    class="flex items-center justify-center space-x-2 rounded px-3 py-1 text-xs font-medium"
                                    >
                                    <x-icon name="device-desktop" size="sm"></x-icon>
                                    <span class="sr-only">System</span>
                                    </div>
                                    </div>
                                    
                                    <livewire:users:admin-theme-toggle />
                                    </li>
                                --}}
                                {{--
                                    <li class="px-6 leading-none">
                                    <livewire:users:admin-theme-toggle />
                                    </li>
                                --}}
                                <li class="!mt-4 px-6 py-4 leading-none">
                                    <x-dropdown placement="bottom-end" class="w-full">
                                        <x-slot name="trigger">
                                            <x-avatar
                                                size="xs"
                                                :src="auth()->user()->avatar_url"
                                                :tooltip="auth()->user()->name"
                                            />
                                            <span class="ml-2.5">
                                                {{ auth()->user()->name }}
                                            </span>
                                        </x-slot>

                                        <x-dropdown.group>
                                            <livewire:users:admin-theme-toggle />
                                        </x-dropdown.group>

                                        <x-dropdown.group>
                                            <x-dropdown.item href="#" icon="user">My account</x-dropdown.item>
                                            <x-dropdown.item
                                                :href="route('characters.index', ['tableFilters' => ['only_my_characters' => ['isActive' => true]]])"
                                                icon="characters"
                                            >
                                                My characters
                                            </x-dropdown.item>
                                        </x-dropdown.group>

                                        <x-dropdown.group>
                                            <x-dropdown.item :href="route('whats-new')" icon="star">
                                                See what's new
                                            </x-dropdown.item>
                                        </x-dropdown.group>

                                        <x-dropdown.group>
                                            <x-dropdown.item type="submit" icon="logout" form="logout-form">
                                                <span>Sign out</span>

                                                <x-slot name="buttonForm">
                                                    <x-form
                                                        :action="route('logout')"
                                                        class="hidden"
                                                        id="logout-form"
                                                    />
                                                </x-slot>
                                            </x-dropdown.item>
                                        </x-dropdown.group>
                                    </x-dropdown>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div
            class="sticky top-0 z-40 flex items-center gap-x-6 border-b border-gray-900/5 bg-white/60 px-4 py-4 backdrop-blur sm:px-6 xl:hidden"
        >
            <button type="button" class="-m-2.5 p-2.5 text-gray-700 xl:hidden" x-on:click="open = true">
                <span class="sr-only">Open sidebar</span>
                <svg
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                    />
                </svg>
            </button>
            <div class="flex-1 text-sm font-semibold leading-6 text-gray-900">Dashboard</div>
            <a href="#">
                <span class="sr-only">Your profile</span>
                <img
                    class="h-8 w-8 rounded-full bg-gray-50"
                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                    alt=""
                />
            </a>
        </div>

        <main
            @class([
                'flex-1 py-10 focus:outline-none xl:ml-72',
                '!pt-[5.25rem]' => app('impersonate')->isImpersonating(),
            ])
            tabindex="0"
        >
            <div class="space-y-6 px-4 sm:px-6 lg:px-8">
                @yield('template')
            </div>
        </main>
        {{--
            <div class="">
            <!-- Activity feed -->
            <aside class="bg-black/10 lg:fixed lg:bottom-0 lg:right-0 lg:top-16 lg:w-96 lg:overflow-y-auto lg:border-l lg:border-white/5">
            <header class="flex items-center justify-between border-b border-white/5 px-4 py-4 sm:px-6 sm:py-6 lg:px-8">
            <h2 class="text-base font-semibold leading-7 text-white">Activity feed</h2>
            <a href="#" class="text-sm font-semibold leading-6 text-indigo-400">View all</a>
            </header>
            <ul role="list" class="divide-y divide-white/5">
            <li class="px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-x-3">
            <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-none rounded-full bg-gray-800" />
            <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-white">Michael Foster</h3>
            <time datetime="2023-01-23T11:00" class="flex-none text-xs text-gray-600">1h</time>
            </div>
            <p class="mt-3 truncate text-sm text-gray-500">
            Pushed to
            <span class="text-gray-400">ios-app</span>
            (
            <span class="font-mono text-gray-400">2d89f0c8</span>
            on
            <span class="text-gray-400">main</span>
            )
            </p>
            </li>
            
            <!-- More items... -->
            </ul>
            </aside>
            </div>
        --}}
    </div>
@endsection
