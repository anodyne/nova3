<script src="{{ URL::to('nova/assets/js/jquery.quicksearch.min.js') }}"></script>
<script>
	
	$('#searchUserRoutes').quicksearch('#userRoutes > div', {
		hide: function()
		{
			$(this).addClass('hidden');
		},
		show: function()
		{
			$(this).removeClass('hidden');
		}
	});

	$('#searchCoreRoutes').quicksearch('#coreRoutes > div', {
		hide: function()
		{
			$(this).addClass('hidden');
		},
		show: function()
		{
			$(this).removeClass('hidden');
		}
	});

	$(document).on('click', '.js-route-action', function(e)
	{
		e.preventDefault();
		
		var action = $(this).data('action');
		var id = $(this).data('route');

		if (action == 'delete')
		{
			$('#deleteRoute').modal({
				remote: "{{ URL::to('ajax/delete/route') }}/" + id
			}).modal('show');
		}

		if (action == 'duplicate')
		{
			$('#duplicateRoute').modal({
				remote: "{{ URL::to('ajax/add/duplicate_route') }}/" + id
			}).modal('show');
		}
	});

</script>