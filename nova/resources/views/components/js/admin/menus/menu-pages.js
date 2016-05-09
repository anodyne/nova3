vue = {
	computed: {
		checked: function () {
			return this.pages.filter(function (page) {
				return page.selected
			}).length
		},

		selectAllLabel: function () {
			if (this.checkAll) {
				return "Unselect All"
			}

			return "Select All"
		}
	},

	data: {
		checkAll: false,
		pages: []
	},

	ready: function () {
		this.pages = []

		for (var p = 0; p < Nova.data.pages.length; p++) {
			var page = Nova.data.pages[p]

			this.pages.push({ id: page.id, name: page.name, selected: false })
		}
	},

	watch: {
		"checkAll": function (newValue, oldValue) {
			for (var p = 0; p < this.pages.length; p++) {
				this.pages[p].selected = newValue
			}
		}
	}
}