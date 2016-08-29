vue = {
	data: {
		loading: true,
		loadingWithError: false,
		users: [],
		search: "",
		statuses: ["active"]
	},

	computed: {
		pendingCount: function () {
			return this.users.filter(function (user) {
				return user.status == 'pending'
			}).length
		}
	},

	methods: {
		removeUser: function (userId) {
			$('#removeUser').modal({
				remote: novaUrl("admin/users/" + userId + "/remove")
			}).modal('show')
		},

		resetFilters: function () {
			this.search = ""
			this.statuses = ["active"]
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
			this.users = response.data.data
		}, response => {
			this.loadingWithError = true
		})
	},

	watch: {
		"users": function (value, oldValue) {
			if (value.length > 0) {
				this.loading = false
			}
		}
	}
}