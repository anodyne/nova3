<template>
    <div class="layout-app-sidebar">
        <nav class="hidden flex-col items-stretch justify-between fixed w-64 bg-white h-screen text-gray-800 border-r md:flex dark:bg-gray-900 dark:text-gray-700">
            <div>
                <a href="#" class="flex justify-center py-9 leading-none"></a>

                <div class="flex flex-col py-3 px-6">
                    <inertia-link href="#" class="flex items-center text-gray-600 font-medium py-2 transition-color transition-faster hover:text-gray-800 dark-hover:text-white">
                        <icon name="home" class="mr-3"></icon>
                        Dashboard
                    </inertia-link>

                    <inertia-link :href="route('themes.index')" class="flex items-center text-gray-600 font-medium py-2 transition-color transition-faster hover:text-gray-800 dark-hover:text-white">
                        <icon name="droplet" class="mr-3"></icon>
                        Themes
                    </inertia-link>

                    <inertia-link :href="route('roles.index')" class="flex items-center text-gray-600 font-medium py-2 transition-color transition-faster hover:text-gray-800 dark-hover:text-white">
                        <icon name="lock" class="mr-3"></icon>
                        Roles
                    </inertia-link>

                    <inertia-link :href="route('users.index')" class="flex items-center text-gray-600 font-medium py-2 transition-color transition-faster hover:text-gray-800 dark-hover:text-white">
                        <icon name="user" class="mr-3"></icon>
                        Users
                    </inertia-link>
                </div>

                <div class="flex flex-col py-3 px-6">
                    <a
                        :href="route('logout')"
                        class="flex items-center text-gray-600 font-medium py-2 transition-color transition-faster hover:text-gray-800 dark-hover:text-white"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    >
                        <icon name="sign-out" class="mr-3"></icon>
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
                </div>

                <div class="text-xs uppercase tracking-widest py-3 px-6 text-gray-500 font-semibold dark:text-gray-700">Resources</div>

                <div class="flex flex-col pb-3 px-6">
                    <a
                        href="https://github.com/anodyne/nova3"
                        target="_blank"
                        class="flex items-center text-gray-600 font-medium py-2 transition-color transition-faster hover:text-gray-800 dark-hover:text-white"
                    >
                        <icon name="github" class="mr-3"></icon>
                        Github Repo
                    </a>

                    <a
                        href="https://github.com/anodyne/nova3/issues"
                        target="_blank"
                        class="flex items-center text-gray-600 font-medium py-2 transition-color transition-faster hover:text-gray-800 dark-hover:text-white"
                    >
                        <icon name="frown" class="mr-3"></icon>
                        Issues
                    </a>
                </div>
            </div>
        </nav>

        <div class="relative flex-1 md:ml-64">
            <nav class="relative flex justify-between items-center bg-white shadow-md py-4 px-8">
                <div class="w-1/3">
                    <div class="flex items-center py-1 px-2 rounded-full bg-gray-200 border border-transparent text-gray-700 focus-within:bg-white focus-within:border-primary-300 focus-within:text-primary-500">
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
                    <a href="#" class="text-gray-700 mr-6 hover:text-gray-600">
                        <icon name="notification"></icon>
                    </a>

                    <div class="avatar avatar-sm">
                        <div class="avatar-image"></div>
                        <div class="avatar-meta text-gray-600">
                            AgentPhoenix
                        </div>
                    </div>

                    <icon name="chevron-down" class="ml-1 text-gray-700 h-4 w-4"></icon>
                </div>
            </nav>

            <header class="py-6 px-8 bg-white">
                <slot name="header"></slot>
            </header>

            <main class="py-8 px-12">
                <slot></slot>
            </main>
        </div>

        <portal-target name="modals"></portal-target>
    </div>
</template>

<script>
import Mousetrap from 'mousetrap';

export default {
    name: 'SidebarLayout',

    created () {
        Mousetrap.bind('/', (e) => {
            e.preventDefault();
            this.$refs.searchInput.focus();
        });
    }
};
</script>
