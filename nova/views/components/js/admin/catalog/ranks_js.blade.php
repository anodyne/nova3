<script type="text/javascript">

	$(document).on('click', '.js-rank-action', function(e)
	{
		var id = $(this).data('id');
		var action = $(this).data('action');
		var location = $(this).data('location');

		if (action == 'delete')
		{
			$('#deleteRankSet').modal({
				remote: "{{ URL::to('ajax/delete/rankset') }}/" + id
			}).modal('show');
		}

		if (action == 'install')
		{
			$('#installRankSet').modal({
				remote: "{{ URL::to('ajax/add/rankset') }}/" + location
			}).modal('show');
		}

		e.preventDefault();
	});

</script>