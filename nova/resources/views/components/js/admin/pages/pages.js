vue = {
	data: {
		pages: Nova.data.pages,
		search: ""
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

	ready: function () {
		this.pages = Nova.data.pages
	}
}