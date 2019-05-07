import Inertia from 'inertia-vue';
import Vue from 'vue';
import store from './Store';

import './global';
import './components';
import './directives';
import './plugins';

const app = document.getElementById('app');

import ToasterOven from '@/Shared/Toasts/ToasterOven';
import SidebarLayout from '@/Shared/Layouts/SidebarLayout';

Vue.component('sidebar-layout', SidebarLayout);

new Vue({
    store,

    mounted () {
        this.$store.set('Icons/initialIcons', window.novaSettings.icons);
        this.$store.set('Theme/initialTheme', window.novaSettings.theme);
        this.$store.set('User/initialUser', window.novaSettings.user);
    },

    render (h) {
        return h('div', [
            h(Inertia, {
                props: {
                    initialPage: JSON.parse(app.dataset.page),
                    resolveComponent: name => {
                        return import(`@/Pages/${name}`).then(
                            module => module.default
                        );
                    }
                }
            }),
            h(ToasterOven)
        ]);
    }
}).$mount(app);
