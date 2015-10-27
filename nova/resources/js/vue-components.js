Vue.component('desktop-lg', {
	template: '<div class="visible-lg-block"><slot></slot></div>'
})

Vue.component('desktop-sm', {
	template: '<div class="visible-md-block"><slot></slot></div>'
})

Vue.component('desktop', {
	template: '<div class="visible-md-block visible-lg-block"><slot></slot></div>'
})

Vue.component('phone-tablet', {
	template: '<div class="visible-xs-block visible-sm-block"><slot></slot></div>'
})

Vue.component('phone', {
	template: '<div class="visible-xs-block"><slot></slot></div>'
})

Vue.component('tablet', {
	template: '<div class="visible-sm-block"><slot></slot></div>'
})

Vue.component('tablet-desktop', {
	template: '<div class="visible-sm-block visible-md-block visible-lg-block"><slot></slot></div>'
})
