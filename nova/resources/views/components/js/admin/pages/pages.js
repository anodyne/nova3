vue = {
	data: {
		pages: Nova.data.pages,
		search: ""
	},

	computed: {
		filteredPages: function () {
			var self = this

			return self.pages.filter(function (page) {
				var regex = new RegExp(self.search, 'i')

				return regex.test(page.name) ||
					regex.test(page.key) ||
					regex.test(page.uri) ||
					regex.test(page.verb)
			})
		}
	},

	methods: {
		removePage: function (pageId) {
			var identifier = '#removePage'
			var url = novaUrl("/admin/pages/" + pageId + "/remove")
			
			$(identifier +' .modal-content').load(url, function () {
				$(identifier).modal('show')
			})
		},

		resetFilters: function () {
			this.search = ""
		}
	}
}