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
			$('#removePage').modal({
				remote: novaUrl("/admin/pages/" + pageId + "/remove")
			}).modal('show')
		},

		resetFilters: function () {
			this.search = ""
		}
	},

	mounted: function () {
		this.pages = Nova.data.pages
	}
}