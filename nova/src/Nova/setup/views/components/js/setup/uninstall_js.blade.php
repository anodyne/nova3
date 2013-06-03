<script type="text/javascript">
	$(document).ready(function(){
		
		$('#next').click(function(){
			
			// Hide the controls
			$('.lower').slideUp();

			// Show the loading graphic
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hide');
			});
		});
	});
</script>