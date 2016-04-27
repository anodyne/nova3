vue = {
	data: {
		loading: true,
		loadingWithError: false,
		permissions: [],
		search: ""
	},

	methods: {
		removePermission: function (permissionId) {
			$('#removePermission').modal({
				remote: novaUrl("admin/access/permissions/" + permissionId + "/remove")
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
			this.permissions = response.data.data
		}, response => {
			this.loadingWithError = true
		})
	},

	watch: {
		"permissions": function (value, oldValue) {
			if (value.length > 0) {
				this.loading = false
			}
		}
	}
}