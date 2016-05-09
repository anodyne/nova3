vue = {
	data: {
		loading: false,
		showEntries: false,
		showEntry: false,
		showForm: false
	},

	events: {
		'form-center-entry.loaded': function () {
			vm.$compile($('#formCenterEntry').get(0))
		}
	},

	methods: {
		removeEntry: function (event) {
			var parent = $(event.target).parent()
			var entryId = parent.data('id')
			var formKey = parent.data('form-key')

			$('#removeFormEntry').modal({
				remote: novaUrl("admin/form-center/" + formKey + "/remove/" + entryId)
			}).modal('show')
		},

		switchToEntries: function () {
			this.loading = true
			this.showEntry = false
			this.showForm = false
			this.showEntries = true
			this.loading = false
		},

		switchToEditEntry: function (event) {
			this.loading = true

			$('#formCenterEntry').html('')

			var parent = $(event.target).parent()
			var entryId = parent.data('id')
			var formKey = parent.data('form-key')
			var url = novaUrl("admin/form-center/" + formKey + "/edit-entry/" + entryId)

			this.$http.get(url).then(response => {
				$('#formCenterEntry').html(response.data.data)

				vm.$emit('form-center-entry.loaded')
			})

			this.showEntries = false
			this.showForm = false
			this.showEntry = true
			this.loading = false
		},

		switchToViewEntry: function (event) {
			this.loading = true

			$('#formCenterEntry').html('')

			var parent = $(event.target).parent()
			var entryId = parent.data('id')
			var formKey = parent.data('form-key')
			var url = novaUrl("admin/form-center/" + formKey + "/show-entry/" + entryId)

			this.$http.get(url).then(response => {
				$('#formCenterEntry').html(response.data.data)

				vm.$emit('form-center-entry.loaded')
			})

			this.showEntries = false
			this.showForm = false
			this.showEntry = true
			this.loading = false
		},

		switchToForm: function () {
			this.loading = true
			this.showEntries = false
			this.showEntry = false
			this.showForm = true
			this.loading = false
		}
	},

	ready: function () {
		if (Nova.data.entryCount > 0) {
			this.showEntries = true
		} else {
			this.showForm = true
		}
	}
}