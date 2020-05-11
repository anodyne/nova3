import Vue from 'vue';
import VuePortal from '@linusborg/vue-simple-portal';
import Dropdown from '@/Shared/Dropdown';

Vue.use(VuePortal, {
    selector: '#portal'
});

Vue.component('dropdown', Dropdown);

// import './global';
// import './components';
// import './plugins';

const app = document.getElementById('app');

window.app = new Vue().$mount(app);
