<script type="text/javascript">
	
	$(document).ready(function(){
		$('#positionDrop').change(function(e)
		{
			e.preventDefault();

			$.ajax({
				type: "GET",
				url: "{{ URL::to('ajax/get/position') }}/" + $('#positionDrop option:selected').val() + "/desc",
				beforeSend: function()
				{
					$('#positionDescPanel').addClass('hide');
					$('#positionLoader').removeClass('hide');
				},
				success: function(data)
				{
					$('#positionDesc').html('');
					$('#positionDesc').append(data);
					$('#positionLoader').addClass('hide');
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