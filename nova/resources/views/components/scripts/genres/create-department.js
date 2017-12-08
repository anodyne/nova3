vue = {
	data: {
		display: 1,
		positions: [{name:''}]
	},

	methods: {
		addPosition () {
			this.positions.push({name:''})
		},

		removePosition (index) {
			this.positions.splice(index, 1)
		},

		toggleDisplay (event) {
			this.display = (event.value === true) ? 1 : 0
		}
	}
}
