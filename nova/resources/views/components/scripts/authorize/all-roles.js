NovaVue = {
	data: {
		roles: Nova.data.roles
	},

	methods: {
		deleteRole (id) {
			let self = this

			$.confirm({
				title: lang('authorize-roles-confirm-delete-title'),
				content: lang('authorize-roles-confirm-delete-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('delete'),
						btnClass: "btn-danger",
						action () {
							axios.delete(route('roles.destroy', {role:id}))
								 .then(function (response) {
								 	let index = _.findIndex(self.roles, function (r) {
										return r.id == id
									})

									self.roles.splice(index, 1)

									flash(
										lang('authorize-roles-flash-deleted-message'),
										lang('authorize-roles-flash-deleted-title')
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
			return route('roles.edit', {role:id})
		}
	}
}
