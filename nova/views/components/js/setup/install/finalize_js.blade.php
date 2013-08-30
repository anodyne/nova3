<script type="text/javascript">
	
	$(document).ready(function()
	{
		$('#next').click(function()
		{
			$('.lower').slideUp();

			$('#loaded').fadeOut('fast', function()
			{
				$('#loading').removeClass('hide');
			});
		});
	});

</script>