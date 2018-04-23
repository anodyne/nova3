vue = {
	data: {
		mobileSearch: false,
		permissions: Nova.data.permissions,
		search: '',
		detail: false,
		selected: null
	},

	computed: {
		filteredPermissions () {
			let self = this

			return self.permissions.filter(function (permission) {
				let searchRegex = new RegExp(self.search, 'i')

				return searchRegex.test(permission.name) || searchRegex.test(permission.key)
			})
		}
	},

	methods: {
		// lang (key) {
		// 	return window.lang(key);
		// },

		deletePermission (id) {
			let self = this

			$.confirm({
				title: lang('authorize-permissions-confirm-delete-title'),
				content: lang('authorize-permissions-confirm-delete-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('delete'),
						btnClass: "btn-danger",
						action () {
							axios.delete(route('permissions.destroy', {permission:id}))
								 .then(function (response) {
								 	let index = _.findIndex(self.permissions, function (p) {
										return p.id == id
									})

									self.permissions.splice(index, 1)

									flash(
										lang('authorize-permissions-flash-deleted-message'),
										lang('authorize-permissions-flash-deleted-title')
									)
								 })
						}
					},
					cancel: {
						text: lang('cancel')
					}
				}
			})
		},

		editLink (id) {
			return route('permissions.edit', {permission:id})
		},

		resetSearch () {
			this.search = ''
			this.mobileSearch = false
		},

		showDetail (permission) {
			this.detail = true
			this.selected = permission
		}
	}
}
