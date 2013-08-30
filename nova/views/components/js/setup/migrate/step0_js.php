<script type="text/javascript">
	$(document).ready(function(){
		$('#next').click(function(){
			// hide the controls
			$('.lower').slideUp();

			// show the loading graphic
			$('#loaded').fadeOut('fast', function(){
				$('#loading').fadeIn();
			});
		});
	});
</script>