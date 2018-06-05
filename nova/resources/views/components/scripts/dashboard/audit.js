NovaVue = {
	data: {
		logs: Nova.data.logs,
		search: ''
	},

	computed: {
		filteredLogs () {
			let self = this

			return self.logs.filter(function (log) {
				let searchRegex = new RegExp(self.search, 'i')

				return searchRegex.test(log.description)
			})
		}
	}
}
