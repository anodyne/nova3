import Vue from 'vue';
import { InertiaApp } from '@inertiajs/inertia-vue';
import VueTippy from 'vue-tippy';
import PortalVue from 'portal-vue';
import Toast from '@/Shared/Toasts';

Vue.use(Toast);
Vue.use(InertiaApp);
Vue.use(PortalVue);
Vue.use(VueTippy, {
    arrow: true,
    arrowType: 'round',
    onShow: options => !!options.props.content
});
