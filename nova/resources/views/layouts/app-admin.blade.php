@extends($meta->structure)

@section('layout')
    <div class="relative min-h-screen">
        <header x-data="{ open: false }" class="bg-gray-1 shadow">
            <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:divide-y lg:divide-gray-6 lg:px-8">
                <div class="relative h-16 flex justify-between">
                    <div class="relative z-10 px-2 flex lg:px-0">
                        <div class="flex-shrink-0 flex items-center">
                            <x-nova-logo-6 class="block h-8 w-auto text-blue-9" />
                        </div>
                    </div>

                    <div class="relative z-0 flex-1 px-2 flex items-center justify-center sm:absolute sm:inset-0">
                        <div class="max-w-xs w-full">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                                    @icon('search', 'flex-shrink-0 h-5 w-5 text-gray-9')
                                </div>
                                <input name="search" id="search" class="block w-full bg-gray-1 border border-gray-6 rounded-md py-2 pl-10 pr-3 text-sm placeholder-gray-9 focus:outline-none focus:text-gray-12 focus:placeholder-gray-9 focus:ring-1 focus:ring-gray-12 focus:border-gray-12 sm:text-sm" placeholder="Search" type="search">
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 flex items-center lg:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" class="rounded-md p-2 inline-flex items-center justify-center text-gray-9 hover:bg-gray-2 hover:text-gray-11 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-12" aria-controls="mobile-menu" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                            <span class="sr-only">Open menu</span>

                            <svg x-description="Icon when menu is closed. Heroicon name: outline/menu" x-state:on="Menu open" x-state:off="Menu closed" class="block h-6 w-6" :class="{ 'hidden': open, 'block': !(open) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>

                            <svg x-description="Icon when menu is open. Heroicon name: outline/x" x-state:on="Menu open" x-state:off="Menu closed" class="hidden h-6 w-6" :class="{ 'block': open, 'hidden': !(open) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="hidden lg:relative lg:z-10 lg:ml-4 lg:flex lg:items-center space-x-4">
                        @livewire('users:notifications')

                        <x-dropdown placement="bottom-end">
                            <x-slot name="trigger">
                                <x-avatar size="xs" :src="auth()->user()->avatar_url" :tooltip="auth()->user()->name" />
                            </x-slot>

                            <x-dropdown.group>
                                <x-dropdown.text>
                                    @livewire('users:dark-mode-toggle')
                                </x-dropdown.text>
                            </x-dropdown.group>

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

                <nav class="hidden lg:py-2 lg:flex lg:space-x-8" aria-label="Global">
                    <x-nav.main-item :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav.main-item>

                    @if (auth()->user()->canWrite())
                        <x-nav.main-item :href="route('writing-overview')" :active="$meta->subnavSection === 'writing'">
                            Writing
                        </x-nav.main-item>
                    @endif

                    <x-nav.main-item :href="route('notes.index')" :active="request()->routeIs('notes.*')">
                        Notes
                    </x-nav.main-item>

                    <x-nav.main-item :href="route('characters.index', 'status=active')" :active="$meta->subnavSection === 'characters'">
                        Characters
                    </x-nav.main-item>

                    @if (auth()->user()->canManageUsers())
                        <x-nav.main-item :href="route('users.index', 'status=active')" :active="$meta->subnavSection === 'users'">
                            Users
                        </x-nav.main-item>
                    @endif

                    @can('update', settings())
                        <x-nav.main-item :href="route('settings.index', 'general')" :active="$meta->subnavSection === 'settings'">
                            Settings
                        </x-nav.main-item>
                    @endcan

                    @if (auth()->user()->canManageSystem())
                        <x-nav.main-item :href="route('system-overview')" :active="$meta->subnavSection === 'system'">
                            System
                        </x-nav.main-item>
                    @endif
                </nav>
            </div>

            <nav x-description="Mobile menu, show/hide based on menu state." class="lg:hidden" aria-label="Global" id="mobile-menu" x-show="open" style="display: none;">
                <div class="pt-2 pb-3 px-2 space-y-1">
                    <x-nav.main-item-mobile :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav.main-item-mobile>

                    @if (auth()->user()->canWrite())
                        <x-nav.main-item-mobile :href="route('writing-overview')" :active="$meta->subnavSection === 'writing'">
                            Writing
                        </x-nav.main-item-mobile>
                    @endif

                    <x-nav.main-item-mobile :href="route('notes.index')" :active="request()->routeIs('notes.*')">
                        Notes
                    </x-nav.main-item-mobile>

                    <x-nav.main-item-mobile :href="route('characters.index', 'status=active')" :active="$meta->subnavSection === 'characters'">
                        Characters
                    </x-nav.main-item-mobile>

                    @if (auth()->user()->canManageUsers())
                        <x-nav.main-item-mobile :href="route('users.index', 'status=active')" :active="$meta->subnavSection === 'users'">
                            Users
                        </x-nav.main-item-mobile>
                    @endif

                    @can('update', settings())
                        <x-nav.main-item-mobile :href="route('settings.index', 'general')" :active="$meta->subnavSection === 'settings'">
                            Settings
                        </x-nav.main-item-mobile>
                    @endcan

                    @if (auth()->user()->canManageSystem())
                        <x-nav.main-item-mobile :href="route('system-overview')" :active="$meta->subnavSection === 'system'">
                            System
                        </x-nav.main-item-mobile>
                    @endif
                </div>

                <div class="border-t border-gray-6 pt-4 pb-3">
                    <div class="px-4 flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=80" alt="">
                        </div>

                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-12">Lisa Marie</div>
                            <div class="text-sm font-medium text-gray-11">lisamarie@example.com</div>
                        </div>

                        <button type="button" class="ml-auto flex-shrink-0 bg-gray-1 rounded-full p-1 text-gray-9 hover:text-gray-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-12">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" x-description="Heroicon name: outline/bell" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </button>
                    </div>

                    <div class="mt-3 px-2 space-y-1">
                        <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-11 hover:bg-gray-2 hover:text-gray-12">Your Profile</a>

                        <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-11 hover:bg-gray-2 hover:text-gray-12">Settings</a>

                        <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-11 hover:bg-gray-2 hover:text-gray-12">Sign out</a>
                    </div>
                </div>
            </nav>
        </header>

        <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8" tabindex="0">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                @if ($meta->subnav)
                    <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-2">
                        @include($meta->subnav)
                    </aside>
                @endif

                <div class="space-y-6 sm:px-6 lg:px-0 {{ $meta->subnav ? 'lg:col-span-10' : 'lg:col-span-12' }}">
                    @yield('template')
                </div>
            </div>
        </main>
    </div>
@endsection