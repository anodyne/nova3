<script type="text/javascript">

	$(document).ready(function()
	{
		<?php if (isset($componentSource) and isset($actionSource)): ?>
			$('[name="component"]').typeahead({
				name: 'component',
				local: <?php echo $componentSource;?>
			});

			$('[name="action"]').typeahead({
				name: 'action',
				local: <?php echo $actionSource;?>
			});
		<?php endif;?>

		$('#searchTasks').quicksearch('#taskSearch .row');
	});

	$(document).on('click', '.js-task-action', function(e)
	{
		e.preventDefault();

		var action = $(this).data('action');
		var id = $(this).data('id');

		if (action == 'delete')
		{
			$('#deleteTask').modal({
				remote: "{{ URL::to('ajax/delete/role_task') }}/" + id,
				keyboard: true
			}).modal('show');
		}

		if (action == 'view')
		{
			$('#rolesWithTask').modal({
				remote: "{{ URL::to('ajax/get/roles_with_task') }}/" + id,
				keyboard: true
			}).modal('show');
		}
	});

</script>