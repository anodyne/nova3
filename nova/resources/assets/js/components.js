import Card from './components/Card.vue'
import Icon from './components/Icon.vue'
import Rank from './components/Rank.vue'
import Flash from './components/Flash.vue'
import Avatar from './components/Avatar.vue'
// import RankPicker from './components/RankPicker.vue'
import UserPicker from './components/UserPicker.vue'
import MediaManager from './components/MediaManager.vue'
import PositionPicker from './components/PositionPicker.vue'
import CharacterPicker from './components/CharacterPicker.vue'
import PositionAvailable from './components/PositionAvailable.vue'

import TextInput from './components/forms/TextInput.vue'
Vue.component('text-input', Vue.extend(TextInput))

import TextBlock from './components/forms/TextBlock.vue'
Vue.component('text-block', Vue.extend(TextBlock))

import Toggle from './components/forms/Toggle.vue'
Vue.component('toggle', Vue.extend(Toggle))

import Switch from './components/forms/Switch.vue'
Vue.component('toggle-switch', Vue.extend(Switch))

Vue.component('card', Vue.extend(Card))
Vue.component('rank', Vue.extend(Rank))
Vue.component('flash', Vue.extend(Flash))
Vue.component('avatar', Vue.extend(Avatar))
Vue.component('media-manager', Vue.extend(MediaManager))
Vue.component('position-available', Vue.extend(PositionAvailable))
Vue.component('icon', Vue.extend(Icon))
// Vue.component('rank-picker', Vue.extend(RankPicker))
Vue.component('user-picker', Vue.extend(UserPicker))
Vue.component('position-picker', Vue.extend(PositionPicker))
Vue.component('character-picker', Vue.extend(CharacterPicker))

import NovaPicker from './components/forms/Picker.vue'
Vue.component('nova-picker', Vue.extend(NovaPicker))

import RankPicker from './components/forms/RankPicker.vue'
Vue.component('rank-picker', Vue.extend(RankPicker))

import ResponsiveCodeSample from './components/ResponsiveCodeSample.vue'
Vue.component('responsive-code-sample', Vue.extend(ResponsiveCodeSample))

Vue.component('mobile-view', require('./components/responsive-mobile').default)
Vue.component('tablet-view', require('./components/responsive-tablet').default)
Vue.component('desktop-view', require('./components/responsive-desktop').default)
