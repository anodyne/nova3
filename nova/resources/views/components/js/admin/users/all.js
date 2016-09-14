vue = {
	data: {
		users: Nova.data.users,
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

			if (this.pendingCount > 0) {
				this.statuses.push("pending")
			}
		},

		statusClass: function (status) {
			if (status == 'pending') {
				return 'tag tag-warning'
			}

			if (status == 'active') {
				return 'tag tag-primary'
			}

			return 'tag tag-default'
		}
	},

	ready: function () {
		if (this.pendingCount > 0) {
			this.statuses.push("pending")
		}
	}
}