<template>
    <div class="layout-app-sidebar">
        <nav class="hidden flex-col items-stretch justify-between fixed w-72 bg-gray-800 h-screen text-gray-400 md:flex">
            <div>
                <a href="#" class="flex justify-center py-9 leading-none bg-gray-900"></a>

                <div class="flex flex-col py-3 px-6">
                    <inertia-link href="#" class="flex items-center text-gray-400 font-medium py-2 hover:text-white">
                        <nova-icon name="home" class="mr-3"></nova-icon>
                        Dashboard
                    </inertia-link>

                    <inertia-link :href="route('themes.index')" class="flex items-center text-gray-400 font-medium py-2 hover:text-white">
                        <nova-icon name="droplet" class="mr-3"></nova-icon>
                        Themes
                    </inertia-link>

                    <inertia-link :href="route('roles.index')" class="flex items-center text-gray-400 font-medium py-2 hover:text-white">
                        <nova-icon name="lock" class="mr-3"></nova-icon>
                        Roles
                    </inertia-link>

                    <inertia-link :href="route('users.index')" class="flex items-center text-gray-400 font-medium py-2 hover:text-white">
                        <nova-icon name="user" class="mr-3"></nova-icon>
                        Users
                    </inertia-link>
                </div>

                <div class="my-3 border-t border-gray-700"></div>

                <div class="flex flex-col py-3 px-6">
                    <a
                        :href="route('logout')"
                        class="flex items-center text-gray-400 font-medium py-2 hover:text-white"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    >
                        <nova-icon name="sign-out" class="mr-3"></nova-icon>
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

                <div class="my-3 border-t border-gray-700"></div>

                <div class="text-xs uppercase tracking-widest py-3 px-6 text-gray-600 font-semibold">Resources</div>

                <div class="flex flex-col pb-3 px-6">
                    <a
                        href="https://github.com/anodyne/nova3"
                        target="_blank"
                        class="flex items-center text-gray-400 font-medium py-2 hover:text-white"
                    >
                        <nova-icon name="github" class="mr-3"></nova-icon>
                        Github Repo
                    </a>

                    <a
                        href="https://github.com/anodyne/nova3/issues"
                        target="_blank"
                        class="flex items-center text-gray-400 font-medium py-2 hover:text-white"
                    >
                        <nova-icon name="frown" class="mr-3"></nova-icon>
                        Issues
                    </a>
                </div>
            </div>
        </nav>

        <div class="relative flex-1 md:ml-72">
            <nav class="relative flex justify-between items-center bg-white shadow-md py-4 px-8">
                <div class="w-1/3">
                    <div class="flex items-center py-1 px-2 rounded-full bg-gray-200 border border-transparent text-gray-500 focus-within:bg-white focus-within:border-primary-300 focus-within:text-primary-500">
                        <nova-icon name="search" class="mr-2"></nova-icon>
                        <input type="text" class="appearance-none bg-transparent text-gray-800 focus:outline-none">
                    </div>
                </div>

                <div class="flex items-center">
                    <a href="#" class="text-gray-500 mr-6 hover:text-gray-600">
                        <nova-icon name="notification"></nova-icon>
                    </a>

                    <div class="avatar avatar-sm">
                        <div class="avatar-image"></div>
                        <div class="avatar-meta text-gray-600">
                            David VanScott
                        </div>
                    </div>

                    <nova-icon name="chevron-down" class="ml-1 text-gray-500 h-4 w-4"></nova-icon>
                </div>
            </nav>

            <header class="py-6 px-8 bg-white">
                <slot name="header"></slot>
            </header>

            <main class="py-8 px-24">
                <slot></slot>
            </main>
        </div>

        <portal-target name="modals"></portal-target>
    </div>
</template>

<script>
export default {
    name: 'SidebarLayout'
};
</script>
