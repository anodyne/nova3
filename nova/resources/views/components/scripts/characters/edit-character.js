NovaVue = {
	data: {
		positions: Nova.data.character.positions
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
