<script type="text/javascript">
	
	$(document).ready(function(){
		$('#positionDrop').change(function(e)
		{
			e.preventDefault();

			$.ajax({
				type: "GET",
				url: "{{ URL::to('ajax/get/position') }}/" + $('#positionDrop option:selected').val() + "/desc",
				success: function(data)
				{
					$('#positionDesc').html('');
					$('#positionDesc').append(data);
					$('#positionDescPanel').removeClass('hide');
				}
			});
		});
		
		$('#rankDrop').change(function(e)
		{
			e.preventDefault();

			$.ajax({
				type: "GET",
				url: "{{ URL::to('ajax/get/rank') }}/" + $('#rankDrop option:selected').val() + "/image",
				success: function(data)
				{
					$('#rankImg').html('');
					$('#rankImg').append(data);
				}
			});
		});

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