<script>
	$('.js-roleAction').click(function(e)
	{
		e.preventDefault();

		var roleId = $(this).data('id');
		var action = $(this).data('action');

		if (action == 'duplicate')
		{
			$.ajax({
				type: "POST",
				url: "{{ url('admin/access/roles') }}/" + roleId + "/duplicate",
				success: function(data)
				{
					location.reload(true);
				}
			});
		}

		if (action == 'remove')
		{
			$('#removeRole').modal({
				remote: "{{ url('admin/access/roles') }}/" + roleId + "/remove"
			}).modal('show');
		}
	});
</script>