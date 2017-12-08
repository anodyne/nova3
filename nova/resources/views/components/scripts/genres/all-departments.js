vue = {
	data: {
		departments: Nova.data.departments,
		mobileSearch: false,
		search: ''
	},

	computed: {
		filteredDepartments () {
			let self = this

			return self.departments.filter(function (dept) {
				let searchRegex = new RegExp(self.search, 'i')

				return searchRegex.test(dept.name)
			})
		}
	},

	methods: {
		deleteDepartment (id) {
			let self = this

			$.confirm({
				title: lang('genre-depts-confirm-delete-title'),
				content: lang('genre-depts-confirm-delete-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('delete'),
						btnClass: "btn-danger",
						action () {
							axios.delete(route('departments.destroy', {department:id}))
								 .then(function (response) {
								 	let index = _.findIndex(self.departments, function (d) {
										return d.id == id
									})

									self.departments.splice(index, 1)

									flash(
										lang('genre-depts-flash-deleted-message'),
										lang('genre-depts-flash-deleted-title')
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
			return route('departments.edit', {department:id})
		},

		resetSearch () {
			this.search = ''
			this.mobileSearch = false
		}
	}
}
