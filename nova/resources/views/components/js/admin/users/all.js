vue = {
	data: {
		users: Nova.data.users,
		search: "",
		statuses: ["active"]
	},

	computed: {
		filteredUsers: function () {
			var self = this

			return self.users.filter(function (user) {
				var regex = new RegExp(self.search, 'i')

				return regex.test(user.name) ||
					regex.test(user.email) ||
					regex.test(user.status) ||
					regex.text(user.nickname)
			})
		},

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
		},

		statusClass: function (status) {
			if (status == 'pending') {
				return 'tag tag-warning'
			}

			if (status == 'active') {
				return 'tag tag-primary'
			}

			return 'tag tag-default'
		},

		statusDisplay: function (user) {
			return user[0].toUpperCase() + user.slice(1)
		}
	},

	mounted: function () {
		if (this.pendingCount > 0) {
			this.statuses.push("pending")
		}
	}
}