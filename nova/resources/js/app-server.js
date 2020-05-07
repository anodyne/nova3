import Vue from 'vue';

import './global';
import './components';
import './plugins';

const app = document.getElementById('app');

window.app = new Vue().$mount(app);
