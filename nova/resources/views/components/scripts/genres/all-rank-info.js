NovaVue = {
	data: {
		hashOfInfo: '',
		hashOfInitialInfo: '',
		info: Nova.data.info,
		initialInfo: Nova.data.info,
		mobileSearch: false,
		search: ''
	},

	computed: {
		dirtyInfo () {
			return this.hashOfInfo != this.hashOfInitialInfo
		},

		filteredInfo () {
			let self = this

			return this.info.filter(function (i) {
				let searchRegex = new RegExp(self.search, 'i')

				return searchRegex.test(i.name) || searchRegex.test(i.short_name)
			})
		}
	},

	methods: {
		deleteInfo (id) {
			let self = this

			$.confirm({
				title: lang('genre-rank-info-confirm-delete-title'),
				content: lang('genre-rank-info-confirm-delete-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('delete'),
						btnClass: "btn-danger",
						action () {
							axios.delete(route('ranks.info.destroy', {info:id}))
								.then(function (response) {
									let index = _.findIndex(self.info, function (i) {
										return i.id == id
									})

									self.info.splice(index, 1)

									self.resetInitialHash()

									flash(
										lang('genre-rank-info-flash-deleted-message'),
										lang('genre-rank-info-flash-deleted-title')
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

		formGroupClasses (field, index) {
			let classes = ['form-group', (this.info[index][field] == '' ? 'has-danger' : '')]

			return classes
		},

		resetInitialHash () {
			this.initialInfo = this.info
			this.hashOfInitialInfo = md5(JSON.stringify(this.initialInfo))
		},

		resetSearch () {
			this.search = ''
			this.mobileSearch = false
		},

		updateInfo () {
			axios.patch(route('ranks.info.update'), {
				info: this.info
			}).then(function (response) {
				flash(
					lang('genre-rank-info-flash-updated-message'),
					lang('genre-rank-info-flash-updated-title')
				)
			}).catch(function (error) {
				if (error.response.status == 422) {
					// Validation error
					flash(
						lang('genre-rank-info-flash-validation-message'),
						lang('genre-rank-info-flash-validation-title'),
						'danger'
					)
				}
			})

			this.resetInitialHash()
		}
	},

	watch: {
		'info': {
			deep: true,
			handler (newValue, oldValue) {
				this.hashOfInfo = md5(JSON.stringify(this.info))
			}
		}
	},

	mounted () {
		// Hash the info
		this.hashOfInitialInfo = md5(JSON.stringify(this.initialInfo))
		this.hashOfInfo = md5(JSON.stringify(this.info))

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

				axios.patch(route('ranks.info.reorder'), {
					info: order
				})
			}
		})
	}
}
