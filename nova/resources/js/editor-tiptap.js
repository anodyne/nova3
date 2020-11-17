import Vue from 'vue';
import 'livewire-vue';
import PostsEditor from './components/PostsEditor';

window.Vue = Vue;

Vue.component('posts-editor', PostsEditor);

window.vm = new Vue().$mount('#app');
