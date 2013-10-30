<script type="text/javascript">
	
	/**
	 * Ignore the current update.
	 */
	$('.js-ignoreVersion').on('click', function(e)
	{
		e.preventDefault();

		$.ajax({
			type: "POST",
			url: "{{ URL::to('setup/ajax/ignore_version') }}",
			data: { version: $(this).data('version'), '_token': "{{ csrf_token() }}" },
			success: function(data)
			{
				location.reload(true);
			}
		});
	});

	/**
	 * Move on to the next step.
	 */
	$('#next').on('click', function()
	{
		// Hide the controls
		$('.lower').slideUp();

		// Show the loading graphic
		$('#loaded').fadeOut('fast', function(){
			$('#loading').removeClass('hidden');
		});
	});
	
</script>