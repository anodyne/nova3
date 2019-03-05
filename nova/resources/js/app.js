import Vue from 'vue';
import store from './store';
import Nova from './nova';
import axios from '@/util/axios';

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
            axios.post(window.route('bootstrap-nova'))
                .then(({ data }) => {
                    this.$store.set('Icons/initialIcons', data.icons);
                    this.$store.set('Theme/initialTheme', data.theme);
                    this.$store.set('Settings/initialSettings', data.settings);
                    this.$store.set('User/initialUser', data.user);
                });
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
            axios.post(window.route('bootstrap-nova'))
                .then(({ data }) => {
                    this.$store.set('Icons/initialIcons', data.icons);
                    this.$store.set('Theme/initialTheme', data.theme);
                    this.$store.set('Settings/initialSettings', data.settings);
                    this.$store.set('User/initialUser', data.user);
                });
        }
    }).$mount(root);
}
