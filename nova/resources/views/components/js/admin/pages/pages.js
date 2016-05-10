vue = {
	data: {
		pages: Nova.data.pages,
		search: "",
		verbs: []
	},

	methods: {
		removePage: function (pageId) {
			$('#removePage').modal({
				remote: novaUrl("/admin/pages/" + pageId + "/remove")
			}).modal('show')
		},

		resetFilters: function () {
			this.search = ""
			this.verbs = []
		}
	},

	ready: function () {
		this.pages = Nova.data.pages
	}
}