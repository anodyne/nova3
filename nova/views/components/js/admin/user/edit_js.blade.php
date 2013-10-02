<script>
	
	$(document).on('click', '.js-user-action', function(e)
	{
		e.preventDefault();

		var action = $(this).data('action');
		var id = $(this).data('id');

		if (action == 'deleteAvatar')
		{
			$('#deleteAvatar').modal({
				remote: "{{ URL::to('ajax/delete/user_avatar') }}/" + id
			}).modal('show');
		}
	});
	
</script>