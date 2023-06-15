@extends($meta->structure)

@php($settings = settings())

@section('layout')
    <div class="relative min-h-screen">
        <header x-data="{ open: false }" class="bg-white dark:bg-gray-900 shadow dark:shadow-md">
            <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:divide-y lg:divide-gray-100 dark:lg:divide-gray-700/50 lg:px-8">
                <div class="relative h-16 flex justify-between">
                    <div class="relative px-2 flex lg:px-0">
                        <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center">
                            @if (app('nova.settings')->getFirstMedia('logo'))
                                <img src="{{ app('nova.settings')->getFirstMediaUrl('logo') }}" alt="logo" class="block h-8 w-auto">
                            @else
                                <x-logos.nova class="hidden md:block h-8 w-auto" />
                                <x-logos.nova-mark class="block md:hidden h-8 w-auto" />
                            @endif
                        </a>
                    </div>

                    <div class="relative z-0 flex-1 px-4 md:px-2 flex items-center justify-center">
                        <div class="max-w-xs w-full">
                            <label for="search" class="sr-only">Search</label>
                            <x-input.field>
                                <x-slot:leadingAddOn>
                                    <x-icon name="search" size="sm"></x-icon>
                                </x-slot:leadingAddOn>

                                <input name="search" id="search" placeholder="Search" type="search" class="flex-1 appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">
                            </x-input.field>
                        </div>
                    </div>

                    <div class="relative z-10 flex items-center lg:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" class="p-2 inline-flex items-center justify-center text-gray-500 focus:outline-none" aria-controls="mobile-menu" x-on:click="open = !open" aria-expanded="false" :aria-expanded="open.toString()">
                            <span class="sr-only">Open menu</span>

                            <svg x-description="Icon when menu is closed. Heroicon name: outline/menu" x-state:on="Menu open" x-state:off="Menu closed" class="block h-7 w-7" :class="{ 'hidden': open, 'block': !(open) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>

                            <svg x-description="Icon when menu is open. Heroicon name: outline/x" x-state:on="Menu open" x-state:off="Menu closed" class="hidden h-7 w-7" :class="{ 'block': open, 'hidden': !(open) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="hidden lg:relative lg:ml-4 lg:flex lg:items-center space-x-4">
                        <livewire:users:notifications />

                        <livewire:users:admin-theme-toggle />

                        <x-dropdown placement="bottom-end">
                            <x-slot:trigger>
                                <x-avatar size="xs" :src="auth()->user()->avatar_url" :tooltip="auth()->user()->name" />
                            </x-slot:trigger>

                            <x-dropdown.group>
                                <x-dropdown.item href="#" icon="user">
                                    My account
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

                                    <x-slot:buttonForm>
                                        <x-form :action="route('logout')" class="hidden" id="logout-form" />
                                    </x-slot:buttonForm>
                                </x-dropdown.item>
                            </x-dropdown.group>
                        </x-dropdown>
                    </div>
                </div>

                <nav class="hidden lg:py-2 lg:flex lg:space-x-8" aria-label="Global">
                    <x-nav.main-item :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav.main-item>

                    @if (auth()->user()->canWrite)
                        <x-nav.main-item :href="route('writing-overview')" :active="$meta->subnavSection === 'writing' || $meta->subnavSection === 'posting'">
                            Writing
                        </x-nav.main-item>
                    @endif

                    <x-nav.main-item :href="route('notes.index')" :active="request()->routeIs('notes.*')">
                        Notes
                    </x-nav.main-item>

                    <x-nav.main-item :href="route('characters.index')" :active="$meta->subnavSection === 'characters'">
                        Characters
                    </x-nav.main-item>

                    @if (auth()->user()->canManageUsers)
                        <x-nav.main-item :href="route('users.index')" :active="$meta->subnavSection === 'users'">
                            Users
                        </x-nav.main-item>
                    @endif

                    @can('update', $settings)
                        <x-nav.main-item :href="route('settings.index', 'general')" :active="$meta->subnavSection === 'settings'">
                            Settings
                        </x-nav.main-item>
                    @endcan

                    @if (auth()->user()->canManageSystem)
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

                    @if (auth()->user()->canWrite)
                        <x-nav.main-item-mobile :href="route('writing-overview')" :active="$meta->subnavSection === 'writing'">
                            Writing
                        </x-nav.main-item-mobile>
                    @endif

                    <x-nav.main-item-mobile :href="route('notes.index')" :active="request()->routeIs('notes.*')">
                        Notes
                    </x-nav.main-item-mobile>

                    <x-nav.main-item-mobile :href="route('characters.index')" :active="$meta->subnavSection === 'characters'">
                        Characters
                    </x-nav.main-item-mobile>

                    @if (auth()->user()->canManageUsers)
                        <x-nav.main-item-mobile :href="route('users.index')" :active="$meta->subnavSection === 'users'">
                            Users
                        </x-nav.main-item-mobile>
                    @endif

                    @can('update', $settings)
                        <x-nav.main-item-mobile :href="route('settings.index', 'general')" :active="$meta->subnavSection === 'settings'">
                            Settings
                        </x-nav.main-item-mobile>
                    @endcan

                    @if (auth()->user()->canManageSystem)
                        <x-nav.main-item-mobile :href="route('system-overview')" :active="$meta->subnavSection === 'system'">
                            System
                        </x-nav.main-item-mobile>
                    @endif
                </div>

                <div class="border-t border-gray-300 pt-4 pb-3">
                    <div class="px-4 flex items-center">
                        <div class="shrink-0">
                            <x-avatar size="xs" :src="auth()->user()->avatar_url" :tooltip="auth()->user()->name" />
                        </div>

                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-900">{{ auth()->user()->name }}</div>
                            <div class="text-sm font-medium text-gray-600">{{ auth()->user()->email }}</div>
                        </div>

                        <button type="button" class="ml-auto shrink-0 bg-white rounded-full p-1 text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                            <span class="sr-only">Switch theme</span>
                            <x-icon name="moon" size="md"></x-icon>
                        </button>

                        <button type="button" class="ml-auto shrink-0 bg-white rounded-full p-1 text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                            <span class="sr-only">View notifications</span>
                            <x-icon name="bell" size="md"></x-icon>
                        </button>
                    </div>

                    <div class="mt-3 px-2 space-y-1">
                        <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">My account</a>

                        <a href="{{ route('whats-new') }}" class="block rounded-md py-2 px-3 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">See what's new</a>

                        <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Sign out</a>
                    </div>
                </div>
            </nav>
        </header>

        <main class="max-w-7xl mx-auto py-8 lg:py-12 lg:px-8 focus:outline-none" tabindex="0">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                @if ($meta->subnav)
                    <aside class="pb-8 px-4 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3 xl:col-span-2">
                        @include($meta->subnav)
                    </aside>
                @endif

                <div class="space-y-6 sm:px-6 lg:px-0 {{ $meta->subnav ? 'lg:col-span-9 xl:col-span-10' : 'lg:col-span-12' }}">
                    @yield('template')

                    <footer class="mx-auto py-4">
                        <div class="flex items-center justify-center text-sm text-gray-400 dark:text-gray-500">
                            <div class="flex items-center space-x-1.5 font-medium">
                                <span>Powered by</span>
                                <a href="https://anodyne-productions.com" target="_blank">
                                    <x-logos.nova-grayscale class="h-5 w-auto" />
                                </a>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </main>

        <x-tailwind.breakpoint />
    </div>
@endsection
