import Vue from 'vue';
import store from './Store';

import './global';
import './components';
import './directives';
import './plugins';

import ToastsManager from '@/Shared/Toasts/ToastsManager';

Vue.component('toasts-manager', ToastsManager);

const app = document.getElementById('nova-app');

window.app = new Vue({
    store,

    mounted () {
        this.$store.set('Icons/initialIcons', window.novaSettings.icons);
        this.$store.set('Theme/initialTheme', window.novaSettings.theme);
        this.$store.set('User/initialUser', window.novaSettings.user);
    }
}).$mount(app);
