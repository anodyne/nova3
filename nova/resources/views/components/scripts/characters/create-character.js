vue = {
	data: {
		positions: [{ id:'' }]
	},

	methods: {
		addPosition () {
			this.positions.push({ id:'' })
		},

		removePosition (index) {
			this.positions.splice(index, 1)
		}
	}
}
