vue = {
	data: {
		groups: Nova.data.rankGroups,
		hashOfInitialGroups: '',
		hashOfGroups: '',
		initialGroups: Nova.data.rankGroups,
		mobileSearch: false,
		search: ''
	},

	computed: {
		dirtyGroups () {
			return this.hashOfGroups != this.hashOfInitialGroups
		},

		filteredGroups () {
			let self = this

			return this.groups.filter(function (group) {
				let searchRegex = new RegExp(self.search, 'i')

				return searchRegex.test(group.name)
			})
		}
	},

	methods: {
		deleteGroup (id) {
			let self = this

			$.confirm({
				title: lang('genre-rank-groups-confirm-delete-title'),
				content: lang('genre-rank-groups-confirm-delete-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('delete'),
						btnClass: "btn-danger",
						action () {
							axios.delete(route('ranks.groups.destroy', {group:id}))
								.then(function (response) {
									let index = _.findIndex(self.groups, function (g) {
										return g.id == id
									})

									self.groups.splice(index, 1)

									self.resetInitialHash()

									flash(
										lang('genre-rank-groups-flash-deleted-message'),
										lang('genre-rank-groups-flash-deleted-title')
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

		duplicateGroup (id) {
			$.confirm({
				title: lang('genre-rank-groups-confirm-duplicate-title'),
				content: "URL:" + route('ranks.groups.duplicate-confirm') + "?group=" + id,
				columnClass: "medium",
				theme: "dark",
				buttons: {
					formSubmit: {
						text: lang('duplicate'),
						btnClass: "btn-success",
						action () {
							$('#duplicateForm').submit()
						}
					},
					cancel: {
						text: lang('cancel')
					}
				}
			})
		},

		formGroupClasses (field, index) {
			let classes = ['form-group', (this.groups[index][field] == '' ? 'has-danger' : '')]

			return classes
		},

		resetInitialHash () {
			this.initialGroups = this.groups
			this.hashOfInitialGroups = md5(JSON.stringify(this.initialGroups))
		},

		resetSearch () {
			this.search = ''
			this.mobileSearch = false
		},

		toggleDisplay (event) {
			let index = _.findIndex(this.groups, function (g) {
				return g.id == $(event.srcEvent.target).parent().data('group')
			})

			if (index > -1) {
				this.groups[index].display = (event.value === true) ? 1 : 0
			}
		},

		updateGroups () {
			axios.patch(route('ranks.groups.update'), {
				groups: this.groups
			}).then(function (response) {
				flash(
					lang('genre-rank-groups-flash-updated-message'),
					lang('genre-rank-groups-flash-updated-title')
				)
			}).catch(function (error) {
				if (error.response.status == 422) {
					// Validation error
					flash(
						lang('genre-rank-groups-flash-validation-message'),
						lang('genre-rank-groups-flash-validation-title'),
						'danger'
					)
				}
			})

			this.resetInitialHash()
		}
	},

	watch: {
		'groups': {
			deep: true,
			handler (newValue, oldValue) {
				this.hashOfGroups = md5(JSON.stringify(this.groups))
			}
		}
	},

	mounted () {
		// Hash the groups
		this.hashOfInitialGroups = md5(JSON.stringify(this.initialGroups))
		this.hashOfGroups = md5(JSON.stringify(this.groups))

		Sortable.create(document.getElementById('sortable'), {
			draggable: '.draggable-item',
			handle: '.sortable-handle',
			onEnd (event) {
				let order = new Array()

				$(event.from).children().each(function () {
					let id = $(this).data('id')

					if (id) {
						order.push(id)
					}
				})

				axios.patch(route('ranks.groups.reorder'), {
					groups: order
				})
			}
		})
	}
}
