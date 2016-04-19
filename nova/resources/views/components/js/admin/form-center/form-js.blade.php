<script>
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
				var entryId = $(event.target).data('id')
				var formKey = $(event.target).data('form-key')

				$('#removeFormEntry').modal({
					remote: "{{ url('admin/form-center') }}/" + formKey + "/remove/" + entryId
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

				var entryId = $(event.target).data('id')
				var formKey = $(event.target).data('form-key')
				var url = "{{ url('admin/form-center') }}/" + formKey + "/edit-entry/" + entryId

				this.$http.get(url).then(response => {
					$('#formCenterEntry').html(response.data)

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

				var entryId = $(event.target).data('id')
				var formKey = $(event.target).data('form-key')
				var url = "{{ url('admin/form-center') }}/" + formKey + "/show-entry/" + entryId

				this.$http.get(url).then(response => {
					$('#formCenterEntry').html(response.data)

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
			var entryCount = {{ $entryCount }}

			if (entryCount > 0) {
				this.showEntries = true
			} else {
				this.showForm = true
			}
		}
	}
</script>