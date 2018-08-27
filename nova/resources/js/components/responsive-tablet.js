export default {
	render (h) {
		return h('div', {
			attrs: {
				class: 'hidden md:block lg:hidden'
			}
		}, this.$slots.default)
	}
}
