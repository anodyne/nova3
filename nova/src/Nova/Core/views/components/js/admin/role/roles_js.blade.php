<script type="text/javascript">
	
	$(document).on('click', '.js-role-action', function(){
		var doaction = $(this).data('action');
		var id = $(this).data('id');

		if (doaction == 'delete')
		{
			$('<div/>').dialog2({
				title: "{{ ucwords(lang('short.delete', lang('role'))) }}",
				content: "{{ URL::to('ajax/delete/role') }}/" + id
			});
		}

		if (doaction == 'duplicate')
		{
			$('<div/>').dialog2({
				title: "{{ ucwords(lang('short.duplicate', lang('role'))) }}",
				content: "{{ URL::to('ajax/add/role_duplicate') }}/" + id
			});
		}

		if (doaction == 'view')
		{
			$('#usersWithRole').modal({
				remote: "{{ URL::to('ajax/info/users_with_role') }}/" + id
			}).modal('show');
		}

		return false;
	});

	$('body').on('hidden', '.modal', function(){
		$(this).removeData('modal');
	});

</script>