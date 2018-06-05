require('./bootstrap')

require('./event-listeners')

require('./components')

const app = new Vue({
	el: '#nova-app',
	mixins: [NovaVue]
})
