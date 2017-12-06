vue = {
	data: {
		permissions: Nova.data.permissions,
		oldPermissions: [],
		search: ''
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
			let result = _.findIndex(this.oldPermissions, function (p) {
				return p == permission
			})

			return (result >= 0)
		}
	},

	mounted () {
		if (Nova.data.oldPermissions !== null) {
			this.oldPermissions = Nova.data.oldPermissions
		}
	}
}
