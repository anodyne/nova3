<template>
    <div class="layout-app-sidebar">
        <nav class="hidden md:flex flex-col items-stretch justify-between fixed w-64 bg-gray-900 h-screen text-gray-400">
            <div>
                <a href="#" class="flex items-center justify-center h-16 leading-none bg-gray-800">
                    <img
                        src="/dist/images/logo.png"
                        alt="Logo"
                        class="h-10 w-auto"
                    >
                </a>

                <div class="flex flex-col py-3 px-6">
                    <inertia-link :href="route('dashboard')" class="flex items-center text-gray-400 py-2 transition-color transition-faster hover:text-gray-200">
                        <icon name="activity" class="mr-3 text-gray-600"></icon>
                        Dashboard
                    </inertia-link>

                    <!-- <inertia-link href="#" class="flex items-center text-gray-400 py-2 transition-color transition-faster hover:text-gray-200">
                        <icon name="settings" class="mr-3 text-gray-600"></icon>
                        Settings
                    </inertia-link> -->

                    <inertia-link href="#" class="flex items-center text-gray-400 py-2 transition-color transition-faster hover:text-gray-200">
                        <icon name="sidebar" class="mr-3 text-gray-600"></icon>
                        Manage
                    </inertia-link>

                    <div class="ml-8 mb-2">
                        <!-- <inertia-link
                            :href="route('roles.index')"
                            class="flex items-center py-1 text-sm transition-color transition-faster"
                            :class="navStyle('characters.*')"
                        >
                            Characters
                        </inertia-link> -->

                        <!-- <inertia-link
                            :href="route('roles.index')"
                            class="flex items-center py-1 text-sm transition-color transition-faster"
                            :class="navStyle('pages.*')"
                        >
                            Pages
                        </inertia-link> -->

                        <inertia-link
                            :href="route('roles.index')"
                            class="flex items-center py-1 text-sm transition-color transition-faster"
                            :class="navStyle('roles.*')"
                        >
                            Roles
                        </inertia-link>

                        <inertia-link
                            :href="route('themes.index')"
                            class="flex items-center py-1 text-sm transition-color transition-faster"
                            :class="navStyle('themes.*')"
                        >
                            Themes
                        </inertia-link>

                        <inertia-link
                            :href="route('users.index')"
                            class="flex items-center py-1 text-sm transition-color transition-faster"
                            :class="navStyle('users.*')"
                        >
                            Users
                        </inertia-link>
                    </div>

                    <!-- <inertia-link href="#" class="flex items-center text-gray-400 py-2 transition-color transition-faster hover:text-gray-200">
                        <icon name="edit" class="mr-3 text-gray-600"></icon>
                        Write
                    </inertia-link> -->

                    <!-- <inertia-link href="#" class="flex items-center text-gray-400 py-2 transition-color transition-faster hover:text-gray-200">
                        <icon name="pie-chart" class="mr-3 text-gray-600"></icon>
                        Reports
                    </inertia-link> -->
                </div>

                <div class="text-xs uppercase tracking-widest py-3 px-6 text-gray-600 font-semibold">Links</div>

                <div class="flex flex-col pb-3 px-6">
                    <a
                        href="https://github.com/anodyne/nova3"
                        target="_blank"
                        class="flex items-center text-gray-400 py-2 transition-color transition-faster hover:text-gray-200"
                    >
                        <icon name="git-pull-request" class="mr-3 text-gray-600"></icon>
                        Github Repo
                    </a>

                    <a
                        href="https://github.com/anodyne/nova3/issues"
                        target="_blank"
                        class="flex items-center text-gray-400 py-2 transition-color transition-faster hover:text-gray-200"
                    >
                        <icon name="frown" class="mr-3 text-gray-600"></icon>
                        Issues
                    </a>
                </div>
            </div>
        </nav>

        <div class="relative flex-1 md:ml-64">
            <nav class="relative flex justify-between items-center bg-gray-300 h-16 px-8">
                <div class="w-1/3">
                    <div class="flex items-center py-1 px-2 rounded-full bg-white border-2 border-transparent text-gray-500 focus-within:bg-white focus-within:border-primary-300 focus-within:text-primary-500">
                        <icon name="search" class="mr-2"></icon>
                        <input
                            ref="searchInput"
                            type="text"
                            class="w-full appearance-none bg-transparent text-gray-800 focus:outline-none"
                            placeholder="Search the site (Press &quot;/&quot; to focus)"
                        >
                    </div>
                </div>

                <div class="flex items-center">
                    <a href="#" class="text-gray-600 mr-6 hover:text-gray-700">
                        <icon name="notification"></icon>
                    </a>

                    <dropdown placement="bottom-end">
                        <div class="flex items-center">
                            <user-avatar :user="$store.get('User')" size="sm"></user-avatar>
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
            </nav>

            <main class="py-12 px-16">
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
                'font-bold text-white': this.route().current(route),
                'text-gray-400 hover:text-gray-200': !this.route().current(route)
            };
        }
    }
};
</script>
