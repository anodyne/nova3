/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')
require('./event-listeners')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Icon from './components/Icon.vue'
import Rank from './components/Rank.vue'
import Flash from './components/Flash.vue'
import Avatar from './components/Avatar.vue'
import RankPicker from './components/RankPicker.vue'
import UserPicker from './components/UserPicker.vue'
import MediaManager from './components/MediaManager.vue'
import PrettyToggle from './components/PrettyToggle.vue'
import PositionPicker from './components/PositionPicker.vue'
import CharacterPicker from './components/CharacterPicker.vue'
import PositionAvailable from './components/PositionAvailable.vue'

Vue.component('rank', Vue.extend(Rank))
Vue.component('flash', Vue.extend(Flash))
Vue.component('avatar', Vue.extend(Avatar))
Vue.component('media-manager', Vue.extend(MediaManager))
Vue.component('position-available', Vue.extend(PositionAvailable))
Vue.component('icon', Vue.extend(Icon))
Vue.component('toggle', Vue.extend(PrettyToggle))
Vue.component('rank-picker', Vue.extend(RankPicker))
Vue.component('user-picker', Vue.extend(UserPicker))
Vue.component('position-picker', Vue.extend(PositionPicker))
Vue.component('character-picker', Vue.extend(CharacterPicker))

import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton)

Vue.component('desktop', {
	template: '<div class="hidden md:block" v-cloak><slot></slot></div>'
})

Vue.component('mobile', {
	template: '<div class="sm:block md:hidden" v-cloak><slot></slot></div>'
})
