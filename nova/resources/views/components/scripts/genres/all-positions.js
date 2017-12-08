vue = {
	data: {
		department: '',
		hashOfInitialPositions: '',
		hashOfPositions: '',
		initialPositions: Nova.data.positions,
		mobileFilter: false,
		mobileSearch: false,
		positions: Nova.data.positions,
		search: ''
	},

	computed: {
		dirtyPositions () {
			return this.hashOfPositions != this.hashOfInitialPositions
		},

		filteredPositions () {
			let self = this

			let filteredPositions = this.positions.filter(function (position) {
				return position.department_id == self.department
			})

			return filteredPositions.filter(function (position) {
				let searchRegex = new RegExp(self.search, 'i')

				return searchRegex.test(position.name)
			})
		}
	},

	methods: {
		deletePosition (id) {
			let self = this

			$.confirm({
				title: lang('genre-positions-confirm-delete-title'),
				content: lang('genre-positions-confirm-delete-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('delete'),
						btnClass: "btn-danger",
						action () {
							axios.delete(route('positions.destroy', {position:id}))
								 .then(function (response) {
								 	let index = _.findIndex(self.positions, function (p) {
										return p.id == id
									})

									self.positions.splice(index, 1)

									self.resetInitialHash()

									flash(
										lang('genre-positions-flash-deleted-message'),
										lang('genre-positions-flash-deleted-title')
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

		formGroupClasses (field, id) {
			let index = _.findIndex(this.positions, function (p) {
				return p.id == id
			})

			let classes = ['form-group', (this.positions[index][field] == '' ? 'has-danger' : '')]

			return classes
		},

		resetInitialHash () {
			this.initialPositions = this.positions
			this.hashOfInitialPositions = md5(JSON.stringify(this.initialPositions))
		},

		resetSearch () {
			this.search = ''
			this.mobileSearch = false
		},

		toggleDisplay (event) {
			let index = _.findIndex(this.positions, function (p) {
				return p.id == $(event.srcEvent.target).parent().data('position')
			})

			if (index > -1) {
				this.positions[index].display = (event.value === true) ? 1 : 0
			}
		},

		updatePositions () {
			axios.patch(route('positions.update'), {
				positions: this.positions
			}).then(function (response) {
				flash(
					lang('genre-positions-flash-updated-message'),
					lang('genre-positions-flash-updated-title')
				)
			}).catch(function (error) {
				if (error.response.status == 422) {
					// Validation error
					flash(
						lang('genre-positions-flash-validation-message'),
						lang('genre-positions-flash-validation-title'),
						'danger'
					)
				}
			})

			this.resetInitialHash()
		}
	},

	watch: {
		'positions': {
			handler (newValue, oldValue) {
				this.hashOfPositions = md5(JSON.stringify(this.positions))
			},
			deep: true
		}
	},

	mounted () {
		// Hash the position objects
		this.hashOfInitialPositions = md5(JSON.stringify(this.initialPositions))
		this.hashOfPositions = md5(JSON.stringify(this.positions))

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

				axios.patch(route('positions.reorder'), {
					positions: order
				})
			}
		})
	}
}
