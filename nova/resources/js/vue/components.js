Vue.component('desktop-lg', {
	template: '<div class="hidden-lg-down" v-cloak><slot></slot></div>'
})

Vue.component('desktop-sm', {
	template: '<div class="hidden-md-down hidden-xl-up" v-cloak><slot></slot></div>'
})

Vue.component('desktop', {
	template: '<div class="hidden-md-down" v-cloak><slot></slot></div>'
})

Vue.component('mobile', {
	template: '<div class="hidden-md-up" v-cloak><slot></slot></div>'
})

Vue.component('phone', {
	template: '<div class="hidden-sm-up" v-cloak><slot></slot></div>'
})

Vue.component('tablet', {
	template: '<div class="hidden-xs-down hidden-md-up" v-cloak><slot></slot></div>'
})

Vue.component('tablet-desktop', {
	template: '<div class="hidden-xs-down" v-cloak><slot></slot></div>'
})
