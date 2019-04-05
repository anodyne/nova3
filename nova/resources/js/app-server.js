import Vue from 'vue';
import store from './Store';

import './global';
import './components';
import './directives';

import NovaNotices from '@/Shared/Notices/NovaNotices';

Vue.component('nova-notices', NovaNotices);

const app = document.getElementById('nova-app');

// window.Nova = new Nova();

window.app = new Vue({
    store,

    mounted () {
        this.$store.set('Icons/initialIcons', window.novaSettings.icons);
        this.$store.set('Theme/initialTheme', window.novaSettings.theme);
        this.$store.set('User/initialUser', window.novaSettings.user);
    }
}).$mount(app);
