<script>
	vue = {
		methods: {
			removeTab: function(event)
			{
				var formKey = $(event.target).data('form-key')
				var tabId = $(event.target).data('id')

				$('#removeTab').modal({
					remote: "{{ url('admin/forms') }}/" + formKey + "/tabs/" + tabId + "/remove"
				}).modal('show')
			}
		}
	}
</script>