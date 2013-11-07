<script>

	$(document).ready(function()
	{
		// Show the first tab
		$('.nav-tabs a:first').tab('show');

		$('.quicksearch-control').each(function()
		{
			// Set the container and input to attach to
			var searchContainer = "#" + $(this).closest('.row').next('.nv-data-table').attr('id') + " .row";
			var searchInput = "#" + $(this).attr('id');

			// Attach the QuickSearch filter
			$(searchInput).quicksearch(searchContainer);
		});

		<?php if (isset($routeSource)): ?>
			$('[name="uri"]').typeahead({
				name: 'uri',
				local: <?php echo $routeSource;?>
			});
		<?php endif;?>
	});

	$('[name="type"]').on('change', function()
	{
		var selected = $('[name="type"] option:selected').val();

		if (selected == 'other' || selected == 'email')
			$('#uriField').addClass('hidden');
		else
			$('#uriField').removeClass('hidden');
	});

	$(document).on('click', '.js-navigation-action', function(e)
	{
		e.preventDefault();

		var action = $(this).data('action');
		var id = $(this).data('id');

		if (action == 'delete')
		{
			$('#deleteSiteContent').modal({
				remote: "{{ URL::to('ajax/delete/navigation') }}/" + id
			}).modal('show');
		}
	});

</script>