import Vue from 'vue';
import store from './store';
import Nova from './nova';

import './components';
import './directives';
import './plugins';

const root = document.getElementById('nova-app');
const isCSR = root.dataset.props !== undefined;

if (isCSR) {
    if (window.app) {
        window.app.$destroy(true);
    }

    window.app = new Vue({
        store,

        mounted () {
            this.$store.set('Icons/initialIcons', window.novaSettings.icons);
            this.$store.set('Theme/initialTheme', window.novaSettings.theme);
            this.$store.set('User/initialUser', window.novaSettings.user);
        },

        render (h) {
            return h(
                Vue.component('NovaApp'), {
                    props: {
                        component: root.dataset.component,
                        props: JSON.parse(root.dataset.props)
                    }
                }
            );
        }
    }).$mount(root);
} else {
    window.Nova = new Nova();

    window.app = new Vue({
        store,

        mounted () {
            this.$store.set('Icons/initialIcons', window.novaSettings.icons);
            this.$store.set('Theme/initialTheme', window.novaSettings.theme);
            this.$store.set('User/initialUser', window.novaSettings.user);
        }
    }).$mount(root);
}
