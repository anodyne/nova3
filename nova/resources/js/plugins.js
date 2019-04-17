import Vue from 'vue';
import VueTippy from 'vue-tippy';
import Toast from '@/Shared/Toasts';
import PortalVue from 'portal-vue';

Vue.use(Toast);
Vue.use(PortalVue);
Vue.use(VueTippy, {
    arrow: true,
    arrowType: 'round'
});
