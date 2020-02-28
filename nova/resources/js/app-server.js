import Vue from 'vue';
import store from './Store';

import './global';
import './components';
import './plugins';

import ToasterOven from '@/Shared/Toasts/ToasterOven';

Vue.component('toaster-oven', ToasterOven);

const app = document.getElementById('app');

window.app = new Vue({
    store,

    created () {
        this.$store.set('Icons/initialIcons', window.novaSettings.icons);
        this.$store.set('Theme/initialTheme', window.novaSettings.theme);
        this.$store.set('User/initialUser', window.novaSettings.user);
    }
}).$mount(app);
