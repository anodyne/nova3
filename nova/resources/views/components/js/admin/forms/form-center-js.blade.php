<script>
	vue = {
		data: {
			hasContent: true,
			loading: false
		},

		events: {
			'form-center.loaded': function () {
				vm.$compile($('.form-center-container .form-center-content').get(0))
			}
		},

		methods: {
			getForm: function (event) {
				var target = $(event.target)
				var formKey = target.data('form-key')

				this.switchToDashboard(formKey, target)
			},

			switchToDashboard: function (formKey, target) {
				this.hasContent = true
				this.loading = true

				var url = "{{ url('admin/form-center') }}/" + formKey + "/dashboard"

				this.$http.get(url).then(response => {
					// Dump the data from the response into the content div
					$('.form-center-container .form-center-content').html(response.data)

					// Loop through the list group and remove any active indicators
					$('.list-group').children().each(function () {
						$(this).removeClass('active')
					})

					// Set the one we clicked as the active item
					target.addClass('active')

					// Emit our event so we can re-compile to be sure components work properly
					vm.$emit('form-center.loaded')

					this.loading = false
				})
			},

			switchView: function () {
				this.loading = true

				var formKey = $(event.target).data('form-key')
				var type = $(event.target).data('form-state')
				var id = $(event.target).data('id')
				var url = (type == "create")
					? "{{ url('admin/form-center') }}/" + formKey + "/create"
					: "{{ url('admin/form-center') }}/" + formKey + "/edit"

				this.$http.get(url).then(response => {
					// Dump the data from the response into the content div
					$('.form-center-container .form-center-content').html(response.data)

					// Emit our event so we can re-compile to be sure components work properly
					vm.$emit('form-center.loaded')

					this.loading = false
				})
			}
		}
	}
</script>