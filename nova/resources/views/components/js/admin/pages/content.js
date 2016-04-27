vue = {
	data: {
		contents: [],
		loading: true,
		loadingWithError: false,
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
	},

	ready: function () {
		var url = Nova.data.apiUrl
		var options = {
			headers: {
				"Accept": Nova.api.acceptHeader
			}
		}

		this.$http.get(url, [], options).then(response => {
			this.contents = response.data.data
		}, response => {
			this.loadingWithError = true
		})
	},

	watch: {
		"contents": function (value, oldValue) {
			if (value.length > 0) {
				this.loading = false
			}
		}
	}
}