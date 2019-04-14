import Vue from 'vue';
import VueTippy from 'vue-tippy';
import Toast from '@/Shared/Toasts';

Vue.use(Toast);
Vue.use(VueTippy, {
    arrow: true,
    arrowType: 'round'
});
