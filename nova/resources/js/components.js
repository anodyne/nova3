import Vue from 'vue';
import SimpleEditor from '@/Shared/Editors/SimpleEditor';

Vue.component('simple-editor', SimpleEditor);

const app = document.getElementById('app');

window.app = new Vue().$mount(app);
