<script>
	vue = {
		methods: {
			removeEntry: function (event) {
				var entryId = $(event.target).data('id')
				var formKey = $(event.target).data('form-key')

				$('#removeFormEntry').modal({
					remote: "{{ url('admin/form-center') }}/" + formKey + "/remove/" + entryId
				}).modal('show')
			}
		}
	}
</script>