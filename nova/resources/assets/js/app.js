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
Vue.component('media-manager', require('./components/MediaManager.vue'));
Vue.component('character-avatar', require('./components/CharacterAvatar.vue'));

Vue.component('rank-picker', require('./components/RankPicker.vue'));
Vue.component('user-picker', require('./components/UserPicker.vue'));
Vue.component('position-picker', require('./components/PositionPicker.vue'));
Vue.component('character-picker', require('./components/CharacterPicker.vue'));

import ToggleButton from 'vue-js-toggle-button';
Vue.use(ToggleButton);

Vue.component('desktop', {
	template: '<div class="d-none d-md-block" v-cloak><slot></slot></div>'
});

Vue.component('mobile', {
	template: '<div class="d-xs-block d-md-none" v-cloak><slot></slot></div>'
});
