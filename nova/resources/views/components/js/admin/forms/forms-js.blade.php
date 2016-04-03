<script>
	vue = {
		methods: {
			removeForm: function (event) {
				var formKey = $(event.target).data('form-key')

				$('#removeForm').modal({
					remote: "{{ url('admin/forms') }}/" + formKey + "/remove"
				}).modal('show')
			}
		}
	}
</script>