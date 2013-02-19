<script type="text/javascript">
	$(document).ready(function(){
		$('#remove').click(function(){
			// hide the controls
			$('.lower').slideUp();

			// show the loading graphic
			$('#loaded').fadeOut('fast', function(){
				$('#loading').fadeIn();
			});
		});
	});
</script>