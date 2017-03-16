vue = {
	data: {
		contents: Nova.data.contents,
		search: ""
	},

	methods: {
		removeContent: function (contentId) {
			$('#removeContent').modal({
				remote: novaUrl("admin/content/" + contentId + "/remove")
			}).modal('show')
		},

		resetFilters: function () {
			this.search = ""
		}
	}
}