NovaVue = {
	data: {
		group: '',
		ranks: Nova.data.ranks,
		mobileFilter: false,
		mobileSearch: false,
		search: ''
	},

	methods: {
		deleteRank (id) {
			let self = this

			$.confirm({
				title: lang('genre-ranks-confirm-delete-title'),
				content: lang('genre-ranks-confirm-delete-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('delete'),
						btnClass: "btn-danger",
						action () {
							axios.delete(route('ranks.items.destroy', {item:id}))
								.then(function (response) {
									let index = _.findIndex(self.ranks, function (r) {
										return r.id == id
									})

									self.ranks.splice(index, 1)

									flash(
										lang('genre-ranks-flash-deleted-message'),
										lang('genre-ranks-flash-deleted-title')
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

		duplicateRank (id) {
			axios.post(route('ranks.items.duplicate', {item:id}))

			window.setTimeout(function () {
				window.location.replace(route('ranks.items.index'))
			}, 1000)
		},

		editLink (id) {
			return route('ranks.items.edit', {item:id})
		},

		filteredRanks () {
			let self = this
			let filteredRanks = this.ranks.filter(function (rank) {
				return rank.group_id == self.group
			})

			return filteredRanks.filter(function (rank) {
				let searchRegex = new RegExp(self.search, 'i')

				return searchRegex.test(rank.info.name) || searchRegex.test(rank.info.short_name)
			})
		},

		resetSearch () {
			this.search = ''
			this.mobileSearch = false
		}
	},

	mounted () {
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

				axios.patch(route('ranks.items.reorder'), {
					items: order
				})
			}
		})
	}
}
