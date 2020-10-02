import Vue from 'vue';
import 'livewire-vue';
import SimpleEditor from './components/SimpleEditor';

window.Vue = Vue;

Vue.component('simple-editor', SimpleEditor);

window.vm = new Vue().$mount('#app');
