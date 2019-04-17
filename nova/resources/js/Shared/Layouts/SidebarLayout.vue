<template>
    <div class="layout-app-sidebar">
        <nav class="sidebar">
            <div>
                <a href="#" class="flex justify-center my-6 leading-0"></a>

                <div class="flex flex-col -mx-6">
                    <inertia-link href="#" class="sidebar-link">
                        <nova-icon name="home" class="mr-3"></nova-icon>
                        Dashboard
                    </inertia-link>

                    <inertia-link :href="route('themes.index')" class="sidebar-link">
                        <nova-icon name="droplet" class="mr-3"></nova-icon>
                        Themes
                    </inertia-link>

                    <inertia-link :href="route('roles.index')" class="sidebar-link">
                        <nova-icon name="lock" class="mr-3"></nova-icon>
                        Roles
                    </inertia-link>

                    <inertia-link :href="route('users.index')" class="sidebar-link">
                        <nova-icon name="user" class="mr-3"></nova-icon>
                        Users
                    </inertia-link>
                </div>

                <div class="sidebar-divider"></div>

                <div class="flex flex-col -mx-6">
                    <a
                        :href="route('logout')"
                        class="sidebar-link"
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

                <div class="sidebar-divider"></div>

                <div class="sidebar-header">Resources</div>

                <div class="flex flex-col -mx-6">
                    <a
                        href="https://github.com/anodyne/nova3"
                        target="_blank"
                        class="sidebar-link"
                    >
                        <nova-icon name="github" class="mr-3"></nova-icon>
                        Github Repo
                    </a>

                    <a
                        href="https://github.com/anodyne/nova3/issues"
                        target="_blank"
                        class="sidebar-link"
                    >
                        <nova-icon name="frown" class="mr-3"></nova-icon>
                        Issues
                    </a>
                </div>
            </div>

            <div class="sidebar-footer">
                <a href="#" class="sidebar-footer-link">
                    <nova-icon name="notification"></nova-icon>
                </a>

                <div class="flex items-center">
                    <div class="avatar avatar-md">
                        <div class="avatar-image"></div>
                    </div>
                </div>

                <a href="#" class="sidebar-footer-link">
                    <nova-icon name="search"></nova-icon>
                </a>
            </div>
        </nav>

        <main class="flex-1 md:ml-72 py-6 px-12">
            <slot></slot>
        </main>

        <portal-target name="modals"></portal-target>
    </div>
</template>

<script>
export default {
    name: 'SidebarLayout'
};
</script>
