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

                <div class="flex items-center"></div>

                <a href="#" class="sidebar-footer-link">
                    <nova-icon name="search"></nova-icon>
                </a>
            </div>
        </nav>

        <main>
            <slot></slot>
        </main>
    </div>
</template>

<script>
import { InertiaLink } from 'inertia-vue';

export default {
    name: 'SidebarLayout',

    components: { InertiaLink },

    props: {
        page: {
            type: Object,
            default: () => {
                return {};
            }
        },
        theme: {
            type: Object,
            default: () => {
                return {};
            }
        }
    }
};
</script>
