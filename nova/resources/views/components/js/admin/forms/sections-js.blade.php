<script>
	vue = {
		methods: {
			removeSection: function(event)
			{
				var formKey = $(event.target).data('form-key')
				var sectionId = $(event.target).data('id')

				$('#removeSection').modal({
					remote: "{{ url('admin/forms') }}/" + formKey + "/sections/" + sectionId + "/remove"
				}).modal('show')
			}
		}
	}
</script>