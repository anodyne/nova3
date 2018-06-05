NovaVue = {
	data: {
		display: 1
	},

	methods: {
		toggleDisplay (event) {
			this.display = (event.value === true) ? 1 : 0
		}
	}
}
