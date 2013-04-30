<script type="text/javascript">
	
	$(document).on('click', '.accordion-toggle', function(){
		var visible = $(this).children('div').hasClass('glyphicon-chevron-down');

		if ( ! visible)
			$(this).children('div').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		else
			$(this).children('div').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
	});

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

</script>