<template>
    <div class="layout-app-sidebar">
        <header class="flex relative w-full h-16 mb-8 bg-white shadow-md">
            <div class="flex items-center w-full md:max-w-6xl mx-auto leading-none">
                <div class="w-1/4">
                    <inertia-link :href="route('dashboard')">
                        <img
                            src="/dist/images/logo.png"
                            alt="Logo"
                            class="h-8 w-auto"
                        >
                    </inertia-link>
                </div>

                <div class="w-1/2 mx-24">
                    <div class="flex items-center py-2 px-4 rounded bg-gray-100 border-2 text-gray-500 transition-all duration-200 focus-within:bg-white focus-within:border-primary-300 focus-within:text-primary-500">
                        <icon name="search" class="mr-2"></icon>
                        <input
                            ref="searchInput"
                            type="text"
                            class="w-full appearance-none bg-transparent text-gray-800 focus:outline-none"
                            placeholder="Search the site (Press &quot;/&quot; to focus)"
                        >
                    </div>
                </div>

                <div class="w-1/4 flex items-center justify-end">
                    <a href="#" class="text-gray-600 mr-6 hover:text-gray-700">
                        <icon name="notification"></icon>
                    </a>

                    <dropdown placement="bottom-end">
                        <div class="flex items-center">
                            <user-avatar
                                :user="$store.get('User')"
                                size="sm"
                                :show-meta-title="false"
                            ></user-avatar>
                            <icon name="chevron-down" class="ml-2 text-gray-500 h-4 w-4"></icon>
                        </div>

                        <template #dropdown>
                            <a href="#" class="dropdown-link">
                                <icon name="user" class="dropdown-icon"></icon>
                                My Account
                            </a>

                            <a href="#" class="dropdown-link">
                                <icon name="users" class="dropdown-icon"></icon>
                                My Characters
                            </a>

                            <hr class="block w-full border-gray-800">

                            <a
                                :href="route('logout')"
                                class="dropdown-link"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            >
                                <icon name="sign-out" class="dropdown-icon"></icon>
                                Log out
                            </a>
                            <form
                                id="logout-form"
                                :action="route('logout')"
                                method="POST"
                                style="display: none;"
                            >
                                <csrf-token></csrf-token>
                            </form>
                        </template>
                    </dropdown>
                </div>
            </div>
        </header>

        <div class="flex relative w-full max-w-6xl mx-auto">
            <nav class="w-56">
                <inertia-link :href="route('dashboard')" class="flex items-center text-gray-700 py-2 transition-colors duration-100 hover:text-gray-800">
                    <icon name="activity" class="mr-3"></icon>
                    Dashboard
                </inertia-link>

                <inertia-link href="#" class="flex items-center text-gray-700 py-2 transition-colors duration-100 hover:text-gray-800">
                    <icon name="sidebar" class="mr-3"></icon>
                    Manage
                </inertia-link>

                <div class="ml-8 mb-2">
                    <!-- <inertia-link
                            :href="route('roles.index')"
                            class="flex items-center py-1 text-sm transition-colors duration-100"
                            :class="navStyle('characters.*')"
                        >
                            Characters
                        </inertia-link> -->

                    <!-- <inertia-link
                            :href="route('roles.index')"
                            class="flex items-center py-1 text-sm transition-colors duration-100"
                            :class="navStyle('pages.*')"
                        >
                            Pages
                        </inertia-link> -->

                    <inertia-link
                        :href="route('roles.index')"
                        class="flex items-center py-1 text-sm tracking-wide transition-colors duration-100"
                        :class="navStyle('roles.*')"
                    >
                        Roles
                    </inertia-link>

                    <inertia-link
                        :href="route('themes.index')"
                        class="flex items-center py-1 text-sm tracking-wide transition-colors duration-100"
                        :class="navStyle('themes.*')"
                    >
                        Themes
                    </inertia-link>

                    <inertia-link
                        :href="route('users.index')"
                        class="flex items-center py-1 text-sm tracking-wide transition-colors duration-100"
                        :class="navStyle('users.*')"
                    >
                        Users
                    </inertia-link>
                </div>
            </nav>

            <main class="flex-1 pl-8 mb-16">
                <slot></slot>
            </main>
        </div>

        <portal-target name="modals"></portal-target>
    </div>
</template>

<script>
import Mousetrap from 'mousetrap';
import UserAvatar from '@/Shared/Avatars/UserAvatar';

export default {
    name: 'SidebarLayout',

    components: { UserAvatar },

    created () {
        Mousetrap.bind('/', (e) => {
            e.preventDefault();
            this.$refs.searchInput.focus();
        });
    },

    methods: {
        navStyle (route) {
            return {
                'font-bold text-primary-500': this.route().current(route),
                'font-medium text-gray-600 hover:text-gray-700': !this.route().current(route)
            };
        }
    }
};
</script>
