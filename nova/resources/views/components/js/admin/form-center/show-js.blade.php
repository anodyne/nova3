<script>
	vue = {
		data: {
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
			switchToEntries: function () {
				this.showEntry = false
				this.showForm = false
				this.showEntries = true
			},

			switchToEditEntry: function (event) {
				var entryId = $(event.target).data('id')
				var url = "{{ url('admin/form-center/edit-entry') }}/" + entryId

				this.$http.get(url).then(response => {
					$('#formCenterEntry').html(response.data)

					vm.$emit('form-center-entry.loaded')
				})

				// Emit our event so we can re-compile to be sure components work properly
				//vm.$emit('form-center-entry.loaded')

				this.showEntries = false
				this.showForm = false
				this.showEntry = true
			},

			switchToViewEntry: function (event) {
				var entryId = $(event.target).data('id')
				var url = "{{ url('admin/form-center/show-entry') }}/" + entryId

				this.$http.get(url).then(response => {
					$('#formCenterEntry').html(response.data)
				})

				this.showEntries = false
				this.showForm = false
				this.showEntry = true
			},

			switchToForm: function () {
				this.showEntries = false
				this.showEntry = false
				this.showForm = true
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