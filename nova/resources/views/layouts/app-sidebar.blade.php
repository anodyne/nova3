@extends($__novaStructure)

@section('layout')
<div x-data="{ sidebarOpen: false }" class="h-screen flex overflow-hidden bg-gray-100">
    <!-- Off-canvas menu for mobile -->
    <div class="md:hidden">
        <div x-show="sidebarOpen" class="fixed inset-0 flex z-40">
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
                class="relative flex-1 flex flex-col max-w-xs w-full bg-white"
            >
                <div class="absolute top-0 right-0 -mr-14 p-1">
                    <button
                        x-on:click="sidebarOpen = false"
                        class="flex items-center justify-center h-12 w-12 rounded-full text-gray-200 hover:text-gray-50 focus:outline-none focus:bg-gray-600"
                        aria-label="Close sidebar"
                    >
                        @icon('close', 'h-6 w-6')
                    </button>
                </div>

                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex-shrink-0 flex items-center px-4">
                        <x-nova-logo class="h-8 w-auto text-blue-500" />
                    </div>

                    <nav class="mt-5 px-2">
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-base leading-6 font-medium text-gray-900 rounded-md bg-gray-100 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150">
                            @icon('dashboard', 'mr-4 h-6 w-6 text-gray-500 group-hover:text-gray-500 group-focus:text-gray-600 transition ease-in-out duration-150')
                            Dashboard
                        </a>
                        <a href="#" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                            @icon('book', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                            My Notes
                        </a>
                        <a href="#" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-100 transition ease-in-out duration-150">
                            @icon('settings', 'mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                            Manage
                        </a>
                    </nav>
                </div>

                <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                    <a href="#" class="flex-shrink-0 group block focus:outline-none">
                        <div class="flex items-center">
                            <div>
                                <img class="inline-block h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                            </div>
                            <div class="ml-3">
                                <p class="text-base leading-6 font-medium text-gray-700 group-hover:text-gray-900">
                                    Tom Cook
                                </p>
                                <p class="text-sm leading-5 font-medium text-gray-500 group-hover:text-gray-700 group-focus:underline transition ease-in-out duration-150">
                                    View profile
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div x-show="sidebarOpen" class="flex-shrink-0 w-14">
                <!-- Force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden | md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
            <div class="h-0 flex-1 flex flex-col pt-6 pb-4 overflow-y-auto">
                <div class="flex items-center flex-shrink-0 px-4">
                    <x-nova-logo class="h-8 w-auto text-blue-500" />
                </div>
                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <nav class="mt-5 flex-1 px-2 bg-white">
                    <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-900 rounded-md bg-gray-100 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150">
                        @icon('dashboard', 'mr-3 h-6 w-6 text-gray-500 group-hover:text-gray-500 group-focus:text-gray-600 transition ease-in-out duration-150')
                        Dashboard
                    </a>
                    <a href="#" class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                        @icon('book', 'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                        My Notes
                    </a>
                    <a href="#" class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition ease-in-out duration-150">
                        @icon('settings', 'mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150')
                        Manage
                    </a>
                </nav>
            </div>

            <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                <a href="#" class="flex-shrink-0 group block">
                    <div class="flex items-center">
                        <div>
                            <img class="inline-block h-9 w-9 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm leading-5 font-medium text-gray-700 group-hover:text-gray-900">
                                Tom Cook
                            </p>
                            <p class="text-xs leading-4 font-medium text-gray-500 group-hover:text-gray-700 transition ease-in-out duration-150">
                                View profile
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <!-- Header for mobile -->
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow | md:hidden">
            <button
                x-on:click.stop="sidebarOpen = true"
                class="px-4 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600"
                aria-label="Open sidebar"
            >
                @icon('menu', 'h-6 w-6')
            </button>

            <div class="flex-1 px-4 flex items-center justify-between">
                <div class="flex-1 flex justify-center">
                    <x-nova-logo class="h-8 w-auto text-blue-500" />
                </div>

                <div x-data="{ open: false }" class="ml-4 flex items-center | md:ml-6">
                    <!-- Profile dropdown -->
                    <div x-on:click.away="open = false" class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button
                                x-on:click="open = !open"
                                class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:shadow-outline"
                                id="user-menu"
                                aria-label="User menu"
                                aria-haspopup="true"
                                x-bind:aria-expanded="open"
                                aria-expanded="false"
                            >
                                <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80" alt="">
                            </button>
                        </div>
                    </div>

                    <div
                        x-show="open"
                        x-description="Profile dropdown panel, show/hide based on dropdown state."
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg"
                    >
                        <div
                            class="py-1 rounded-md bg-white shadow-xs"
                            role="menu"
                            aria-orientation="vertical"
                            aria-labelledby="user-menu"
                        >
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150" role="menuitem">Your Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150" role="menuitem">Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150" role="menuitem">Sign out</a>
                        </div>
                    </div>
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
