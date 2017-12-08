vue = {
	data: {
		selected: [],
		users: Nova.data.users
	},

	methods: {
		toggleAll () {
			let self = this

			if (this.selected.length == this.users.length) {
				// Everything is selected and CheckAll is unchecked
				this.selected = []
			} else if (this.selected.length == 0) {
				// Nothing is selected and CheckAll is checked
				_.forEach(this.users, function (user) {
					self.selected.push(user.id)
				})
			} else if (this.selected.length > 0 && this.selected.length < this.users.length) {
				// Something is selected and CheckAll is checked
				_.forEach(this.users, function (user) {
					let find = _.findIndex(self.selected, function (s) {
						return s == user.id
					})

					let inSelected = find >= 0

					if (! inSelected) {
						self.selected.push(user.id)
					}
				})
			}
		}
	},

	watch: {
		selected (newValue, oldValue) {
			let checkAll = $('[name="check-all"]')

			if (newValue.length > 0 && newValue.length < this.users.length) {
				checkAll.prop('checked', false)
						.prop('indeterminate', true)
			}

			if (newValue.length == this.users.length) {
				checkAll.prop('indeterminate', false)
						.prop('checked', true)
			}

			if (newValue.length == 0) {
				checkAll.prop('indeterminate', false)
						.prop('checked', false)
			}
		}
	}
}
