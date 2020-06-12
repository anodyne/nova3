import { InertiaApp } from '@inertiajs/inertia-vue';
import Vue from 'vue';
import store from './Store';

import './global';
import './components';
import './plugins';

import MasterInertia from '@/Shared/MasterInertia';
import AdminLayout from '@/Shared/Layouts/AdminLayout';

Vue.use(InertiaApp);

Vue.component('admin-layout', AdminLayout);

const app = document.getElementById('app');

new Vue({
    store,

    render (h) {
        return h(MasterInertia, [
            h(InertiaApp, {
                props: {
                    initialPage: JSON.parse(app.dataset.page),
                    resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default)
                }
            })
        ]);
    }
}).$mount(app);
