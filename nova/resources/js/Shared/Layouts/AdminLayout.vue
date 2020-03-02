<template>
    <div class="h-screen flex overflow-hidden bg-gray-100">
        <!-- Off-canvas menu for mobile -->
        <div class="md:hidden">
            <div
                class="fixed inset-0 z-30 bg-gray-600 opacity-0 pointer-events-none transition-opacity ease-linear duration-300"
                :class="{ 'opacity-75 pointer-events-auto': sidebarOpen, 'opacity-0 pointer-events-none': !sidebarOpen }"
            ></div>

            <div
                class="fixed inset-y-0 left-0 flex flex-col z-40 max-w-xs w-full bg-gray-800 transform ease-in-out duration-300"
                :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
            >
                <div class="absolute top-0 right-0 -mr-14 p-1">
                    <button
                        v-show="sidebarOpen"
                        class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600"
                        @click="sidebarOpen = false"
                    >
                        <icon name="x" class="h-8 w-8 text-white"></icon>
                    </button>
                </div>
                <div class="flex-shrink-0 flex items-center h-16 px-4 bg-gray-900">
                    <img
                        src="/dist/images/logo.png"
                        alt="Logo"
                        class="h-8 w-auto"
                    >
                </div>
                <div class="flex-1 h-0 overflow-y-auto">
                    <nav class="px-2 py-4">
                        <inertia-link :href="$route('dashboard')" class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-white bg-gray-900 focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150">
                            <icon name="activity" class="mr-4 h-6 w-6 text-gray-300 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"></icon>
                            Dashboard
                        </inertia-link>

                        <inertia-link :href="$route('notes.index')" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150">
                            <icon name="book-open" class="mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"></icon>
                            My Notes
                        </inertia-link>

                        <inertia-link href="#" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150">
                            <icon name="sidebar" class="mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"></icon>
                            Manage
                        </inertia-link>

                        <div class="ml-12 mb-2">
                            <inertia-link
                                :href="$route('roles.index')"
                                class="flex items-center py-1 text-sm font-medium transition ease-in-out duration-150"
                                :class="subnavStyle('roles.*')"
                            >
                                Roles
                            </inertia-link>

                            <inertia-link
                                :href="$route('themes.index')"
                                class="flex items-center py-1 text-sm font-medium transition ease-in-out duration-150"
                                :class="subnavStyle('themes.*')"
                            >
                                Themes
                            </inertia-link>

                            <inertia-link
                                :href="$route('users.index')"
                                class="flex items-center py-1 text-sm font-medium transition ease-in-out duration-150"
                                :class="subnavStyle('users.*')"
                            >
                                Users
                            </inertia-link>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                    <img
                        src="/dist/images/logo.png"
                        alt="Logo"
                        class="h-8 w-auto"
                    >
                </div>
                <div class="h-0 flex-1 flex flex-col overflow-y-auto">
                    <!-- Sidebar component, swap this element with another sidebar if you like -->
                    <nav class="flex-1 px-2 py-4 bg-gray-800">
                        <inertia-link
                            :href="$route('dashboard')"
                            class="group flex items-center px-2 py-2 leading-5 font-medium rounded-md  focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150"
                            :class="navStyle('dashboard')"
                        >
                            <icon name="activity" class="mr-3 h-6 w-6 text-gray-300 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"></icon>
                            Dashboard
                        </inertia-link>

                        <inertia-link
                            :href="$route('notes.index')"
                            class="mt-1 group flex items-center px-2 py-2 leading-5 font-medium rounded-md focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150"
                            :class="navStyle('notes.*')"
                        >
                            <icon name="book-open" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"></icon>
                            My Notes
                        </inertia-link>

                        <inertia-link
                            href="#"
                            class="mt-1 group flex items-center px-2 py-2 leading-5 font-medium rounded-md focus:outline-none focus:bg-gray-700 transition ease-in-out duration-150"
                            :class="navStyle('manage')"
                        >
                            <icon name="sidebar" class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"></icon>
                            Manage
                        </inertia-link>

                        <div class="ml-11 mb-2">
                            <inertia-link
                                :href="$route('roles.index')"
                                class="flex items-center py-1 text-sm font-medium transition ease-in-out duration-150"
                                :class="subnavStyle('roles.*')"
                            >
                                Roles
                            </inertia-link>

                            <inertia-link
                                :href="$route('themes.index')"
                                class="flex items-center py-1 text-sm font-medium transition ease-in-out duration-150"
                                :class="subnavStyle('themes.*')"
                            >
                                Themes
                            </inertia-link>

                            <inertia-link
                                :href="$route('users.index')"
                                class="flex items-center py-1 text-sm font-medium transition ease-in-out duration-150"
                                :class="subnavStyle('users.*')"
                            >
                                Users
                            </inertia-link>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 | md:hidden" @click.stop="sidebarOpen = true">
                    <icon name="menu" class="h-6 w-6"></icon>
                </button>
                <div class="flex-1 px-4 flex justify-between | md:px-6">
                    <div class="flex-1 flex">
                        <div class="w-full flex md:ml-0">
                            <label for="search_field" class="sr-only">Search</label>
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                    <icon name="search" class="h-5 w-5"></icon>
                                </div>
                                <input
                                    id="search_field"
                                    class="block w-full h-full pl-8 pr-3 py-2 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 sm:text-sm"
                                    placeholder="Search"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <button class="p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500">
                            <icon name="bell" class="h-6 w-6"></icon>
                        </button>
                        <div
                            class="ml-3 relative"
                            x-data="{ open: false }"
                            @click.away="open = false"
                        >
                            <dropdown placement="bottom-end">
                                <avatar size="xs" :image-url="$page.auth.user.avatar_url"></avatar>

                                <template #dropdown="{ styles }">
                                    <a href="#" :class="styles.link">
                                        <icon name="user" :class="styles.icon"></icon>
                                        My Account
                                    </a>

                                    <a href="#" :class="styles.link">
                                        <icon name="users" :class="styles.icon"></icon>
                                        My Characters
                                    </a>

                                    <div :class="styles.divider"></div>

                                    <a
                                        :href="$route('logout')"
                                        :class="styles.link"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                    >
                                        <icon name="log-out" :class="styles.icon"></icon>
                                        Log out
                                    </a>
                                    <form
                                        id="logout-form"
                                        :action="$route('logout')"
                                        method="POST"
                                        style="display: none;"
                                    >
                                        <csrf-token></csrf-token>
                                    </form>
                                </template>
                            </dropdown>
                        </div>
                    </div>
                </div>
            </div>

            <main
                class="flex-1 relative z-0 overflow-y-auto py-6 focus:outline-none"
                tabindex="0"
                x-data
                x-init="$el.focus()"
            >
                <div class="max-w-5xl mx-auto px-4 sm:px-6 md:px-8">
                    <slot></slot>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import Mousetrap from 'mousetrap';
import Avatar from '@/Shared/Avatar';

export default {
    name: 'AdminLayout',

    components: { Avatar },

    data () {
        return {
            sidebarOpen: false
        };
    },

    created () {
        Mousetrap.bind('/', (e) => {
            e.preventDefault();
            this.$refs.searchInput.focus();
        });
    },

    methods: {
        navStyle (route) {
            return {
                'bg-gray-900 text-white': this.$route().current(route),
                'text-gray-300 hover:bg-gray-700 hover:text-white focus:text-white': !this.$route().current(route)
            };
        },

        subnavStyle (route) {
            return {
                'text-white': this.$route().current(route),
                'text-gray-400 hover:text-gray-300 focus:text-gray-300': !this.$route().current(route)
            };
        }
    }
};
</script>
