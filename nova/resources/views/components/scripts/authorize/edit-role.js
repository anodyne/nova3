vue = {
	data: {
		permissions: Nova.data.permissions,
		oldPermissions: [],
		search: '',
		role: Nova.data.role
	},

	computed: {
		filteredPermissions () {
			let self = this

			return this.permissions.filter(function (permission) {
				let regex = new RegExp(self.search, 'i')

				return regex.test(permission.name) || regex.test(permission.key)
			})
		}
	},

	methods: {
		isChecked (permission) {
			let searchRole = _.find(this.role.permissions, function (p) {
				return p.id == permission
			})

			let searchOld = _.findIndex(this.oldPermissions, function (p) {
				return p == permission
			})

			if (searchRole || searchOld >= 0) {
				return true
			}

			return false
		}
	},

	mounted () {
		if (Nova.data.oldPermissions !== null) {
			this.oldPermissions = Nova.data.oldPermissions
		}
	}
}
