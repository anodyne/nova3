<script type="text/javascript">

	$(document).on('click', '.js-task-action', function(){
		var doaction = $(this).data('action');
		var id = $(this).data('id');

		if (doaction == 'delete')
		{
			$('#deleteTask').modal({
				remote: "{{ URL::to('ajax/delete/role_task') }}/" + id,
				keyboard: true
			}).modal('show');
		}

		if (doaction == 'view')
		{
			$('#rolesWithTask').modal({
				remote: "{{ URL::to('ajax/info/roles_with_task') }}/" + id,
				keyboard: true
			}).modal('show');
		}

		return false;
	});

	$('body').on('hidden', '.modal', function(){
		$(this).removeData('modal');
	});

</script>