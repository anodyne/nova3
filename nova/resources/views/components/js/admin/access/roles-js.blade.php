<script>
	vue = {
		methods: {
			duplicateRole: function (event)
			{
				$('#duplicateRole').modal({
					remote: "{{ url('admin/access/roles') }}/" + $(event.target).data('id') + "/duplicate"
				}).modal('show')
			},

			removeRole: function (event)
			{
				$('#removeRole').modal({
					remote: "{{ url('admin/access/roles') }}/" + $(event.target).data('id') + "/remove"
				}).modal('show')
			}
		}
	}
</script>