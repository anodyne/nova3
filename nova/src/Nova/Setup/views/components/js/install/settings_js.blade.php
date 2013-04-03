<script type="text/javascript">
	$(document).ready(function(){
		
		$('#positionDrop').change(function(){
			
			$.ajax({
				type: "POST",
				url: "{{ URL::to('ajax/info/position_desc') }}",
				data: { position: $('#positionDrop option:selected').val() },
				success: function(data){
					$('#positionDesc').html('');
					$('#positionDesc').append(data);
					$('#positionDescPanel').removeClass('hide');
				}
			});
			
			return false;
		});
		
		$('#rankDrop').change(function(){
			
			$.ajax({
				type: "POST",
				url: "{{ URL::to('ajax/info/rank_image') }}",
				data: {
					rank: $('#rankDrop option:selected').val(),
					location: 'default'
				},
				success: function(data){
					$('#rankImg').html('');
					$('#rankImg').append(data);
				}
			});
			
			return false;
		});

		$('#next').click(function(){
			
			$('.lower').slideUp();

			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hide');
			});
		});
	});
</script>