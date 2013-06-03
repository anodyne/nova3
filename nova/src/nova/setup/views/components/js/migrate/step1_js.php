<script type="text/javascript">
	$(document).ready(function(){
		
		$(document).on('click', '#next', function(){
			// hide the controls
			$('.lower').slideUp();

			// show the loading graphic
			$('#loaded').fadeOut('fast', function(){
				$('#loading').fadeIn();
			});
		});
	});
</script>