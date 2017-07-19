/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('rank', require('./components/Rank.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('user-avatar', require('./components/UserAvatar.vue'));

import ToggleButton from 'vue-js-toggle-button';
Vue.use(ToggleButton);

Vue.component('desktop', {
	template: '<div class="hidden-md-down" v-cloak><slot></slot></div>'
});

Vue.component('mobile', {
	template: '<div class="hidden-lg-up" v-cloak><slot></slot></div>'
});

Vue.component('phone', {
	template: '<div class="hidden-sm-up" v-cloak><slot></slot></div>'
});

Vue.component('tablet', {
	template: '<div class="hidden-xs-down hidden-md-up" v-cloak><slot></slot></div>'
});
