import Inertia from 'inertia-vue';
import Vue from 'vue';
import store from './Store';

import './global';
import './components';
import './directives';

const app = document.getElementById('nova-app');

import { InertiaLink } from 'inertia-vue';
import SidebarLayout from '@/Shared/Layouts/SidebarLayout';

Vue.component('inertia-link', InertiaLink);
Vue.component('sidebar-layout', SidebarLayout);

new Vue({
    store,

    mounted () {
        this.$store.set('Icons/initialIcons', window.novaSettings.icons);
        this.$store.set('Theme/initialTheme', window.novaSettings.theme);
        this.$store.set('User/initialUser', window.novaSettings.user);
    },

    render (h) {
        return h(Inertia, {
            props: {
                component: app.dataset.component,
                props: JSON.parse(app.dataset.props),
                resolveComponent: component => {
                    return import(`@/Pages/${component}`).then(
                        module => module.default
                    );
                }
            }
        })
    }
}).$mount(app);
