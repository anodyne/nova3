<script type="text/javascript">
	$(document).ready(function(){
		
		$('#remove').click(function(){
			
			// Hide the controls
			$('.lower').slideUp();

			// Show the loading graphic
			$('#loaded').fadeOut('fast', function(){
				$('#loading').fadeIn();
			});
		});
	});
</script>