<script>
	$('.js-roleAction').click(function(e)
	{
		e.preventDefault();

		var roleId = $(this).data('id');
		var action = $(this).data('action');

		if (action == 'remove')
		{
			$('#removeRole').modal({
				remote: "{{ url('admin/access/roles') }}/" + roleId + "/remove"
			}).modal('show');
		}
	});
</script>