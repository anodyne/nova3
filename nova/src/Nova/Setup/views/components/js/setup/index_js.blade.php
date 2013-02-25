<script type="text/javascript">
	
	/**
	 * Ignore the current update.
	 */
	$('.js-ignoreVersion').on('click', function(){
		
		$.ajax({
			type: "POST",
			url: "{{ URL::to('setup/ajax/ignore_version') }}",
			data: { version: $(this).data('version') },
			success: function(data){
				location.reload(true);
			}
		});
		
		return false;
	});

	/**
	 * Move on to the next step.
	 */
	$('#next').on('click', function(){

		// Hide the controls
		$('.lower').slideUp();

		// Show the loading graphic
		$('#loaded').fadeOut('fast', function(){
			$('#loading').fadeIn();
		});
	});
</script>