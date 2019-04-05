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

                    <inertia-link href="#" class="sidebar-link">
                        <nova-icon name="file" class="mr-3"></nova-icon>
                        Pages
                    </inertia-link>

                    <inertia-link href="#" class="sidebar-link">
                        <nova-icon name="user" class="mr-3"></nova-icon>
                        Authentication
                    </inertia-link>

                    <inertia-link href="#" class="sidebar-link">
                        <nova-icon name="layout" class="mr-3"></nova-icon>
                        Layouts
                    </inertia-link>
                </div>

                <div class="sidebar-divider"></div>

                <div class="sidebar-header">Documentation</div>

                <div class="flex flex-col -mx-6">
                    <inertia-link href="#" class="sidebar-link">
                        <nova-icon name="clipboard" class="mr-3"></nova-icon>
                        Getting started
                    </inertia-link>

                    <inertia-link href="#" class="sidebar-link">
                        <nova-icon name="book-open" class="mr-3"></nova-icon>
                        Components
                    </inertia-link>

                    <inertia-link href="#" class="sidebar-link">
                        <nova-icon name="git-branch" class="mr-3"></nova-icon>
                        Changelog
                    </inertia-link>

                    <inertia-link
                        :href="route('logout')"
                        class="sidebar-link"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    >
                        <nova-icon name="sign-out" class="mr-3"></nova-icon>
                        Log out
                    </inertia-link>
                    <form
                        id="logout-form"
                        :action="route('logout')"
                        method="POST"
                        style="display: none;"
                    >
                        @csrf
                    </form>
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
