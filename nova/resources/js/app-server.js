import Vue from 'vue';
import VuePortal from '@linusborg/vue-simple-portal';
import Dropdown from '@/Shared/Dropdown';
import Modal from '@/Shared/Modal';
import SimpleEditor from '@/Shared/Editors/SimpleEditor';

Vue.use(VuePortal, {
    selector: '#portal'
});

Vue.component('modal', Modal);
Vue.component('dropdown', Dropdown);
Vue.component('simple-editor', SimpleEditor);

const app = document.getElementById('app');

window.app = new Vue().$mount(app);
