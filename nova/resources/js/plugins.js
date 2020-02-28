import Vue from 'vue';
import { InertiaApp } from '@inertiajs/inertia-vue';
import VueTippy from 'vue-tippy';
import VuePortal from '@linusborg/vue-simple-portal';
import Toast from '@/Shared/Toasts';

Vue.use(Toast);
Vue.use(InertiaApp);
Vue.use(VuePortal, {
    selector: '#portal'
});
Vue.use(VueTippy, {
    arrow: true,
    arrowType: 'round',
    onShow: options => !!options.props.content
});
