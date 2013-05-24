<script type="text/javascript">
	
	$(document).on('click', '.js-route-action', function(){
		var doaction = $(this).data('action');
		var id = $(this).data('route');

		if (doaction == 'delete')
		{
			$('#deleteRole').modal({
				remote: "{{ URL::to('ajax/delete/role') }}/" + id
			}).modal('show');
		}

		if (doaction == 'duplicate')
		{
			$('#duplicatePage').modal({
				remote: "{{ URL::to('ajax/add/duplicate_page') }}/" + id
			}).modal('show');
		}

		if (doaction == 'view')
		{
			$('#usersWithRole').modal({
				remote: "{{ URL::to('ajax/info/users_with_role') }}/" + id
			}).modal('show');
		}

		return false;
	});

</script>