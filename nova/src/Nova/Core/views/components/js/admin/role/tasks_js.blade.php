<script type="text/javascript">

	$(document).on('click', '.js-task-action', function(){
		var doaction = $(this).data('action');
		var id = $(this).data('id');

		if (doaction == 'delete')
		{
			$('<div/>').dialog2({
				title: "{{ ucwords(lang('short.delete', lang('role'))) }}",
				content: "{{ URL::to('ajax/delete/role_task') }}/" + id
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
			$('<div/>').dialog2({
				title: "{{ ucwords(langConcat('users with this role')) }}",
				content: "{{ URL::to('ajax/info/role_users') }}/" + id
			});
		}

		return false;
	});

</script>