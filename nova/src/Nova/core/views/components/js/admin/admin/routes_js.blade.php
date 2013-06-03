<script type="text/javascript">
	
	$(document).ready(function(){
		$('#searchUserRoutes').quicksearch('#userRoutes tbody tr');
		$('#searchCoreRoutes').quicksearch('#coreRoutes tbody tr');
	});

	$(document).on('click', '.js-route-action', function(){
		var doaction = $(this).data('action');
		var id = $(this).data('route');

		if (doaction == 'delete')
		{
			$('#deletePage').modal({
				remote: "{{ URL::to('ajax/delete/route') }}/" + id
			}).modal('show');
		}

		if (doaction == 'duplicate')
		{
			$('#duplicatePage').modal({
				remote: "{{ URL::to('ajax/add/duplicate_route') }}/" + id
			}).modal('show');
		}

		if (doaction == 'add')
		{
			$('#addPage').modal({
				remote: "{{ URL::to('ajax/update/route') }}"
			}).modal('show');
		}

		if (doaction == 'edit')
		{
			$('#editPage').modal({
				remote: "{{ URL::to('ajax/update/route') }}/" + id
			}).modal('show');
		}

		return false;
	});

</script>