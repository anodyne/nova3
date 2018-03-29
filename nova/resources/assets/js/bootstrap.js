import LoDash from 'lodash'
import jQuery from 'jquery'
import Vue from 'vue'
import Moment from 'moment'
import JConfirm from 'jquery-confirm'
import WebUIPopover from 'webui-popover'
import md5 from 'md5'
import Sortable from 'sortablejs'
import SweetAlert from 'sweetalert2'
import Axios from 'axios'

window._ = LoDash

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
	window.$ = window.jQuery = jQuery
	window.jconfirm = JConfirm
	window.webuiPopover = WebUIPopover
} catch (e) {}

window.Vue = Vue
window.md5 = md5
window.moment = Moment
window.Sortable = Sortable
window.swal = SweetAlert

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = Axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
	console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

window.events = new Vue()

window.flash = function (message, title, level = 'success') {
	window.events.$emit('flash', message, title, level)
};

// window.route = function (name, args = {}) {
// 	// Grab the URI from the list of routes
// 	let uri = window.Nova.routes[name]

// 	// Loop through the arguments and replace the variable with its value
// 	Object.keys(args).map((a) => uri = uri.replace(`{${a}}`, args[a]))

// 	// Put the full URL back together
// 	return [window.Nova.system.baseUrl, uri].join('/')
// };

window.icon = function (name, attributes = '') {
	// Grab the template
	let template = window.Nova.iconTemplate
	let icon = window.Nova.icons[name]

	template = template.replace('%2$s', attributes)

	return template.replace('%1$s', icon)
}

window.lang = function (key, variables = '') {
	// Get the string
	let string = window.Nova.lang[key]

	// TODO: Add the gender to the variables
	// variables.push({1: window.Nova.user.gender})

	// TODO: handle PLURAL

	// TODO: handle GENDER

	// Loop through the variables and replace the variable with its value
	Object.keys(variables).map((v) => string = string.replace(`$${v}`, variables[v]))

	return string
}
