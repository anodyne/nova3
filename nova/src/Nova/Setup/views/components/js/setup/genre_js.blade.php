<script type="text/javascript">
	$(document).on('click', '.js-do-install', function(){
		
		var $row = $(this).parent().parent();
		var $th = $(this);
		var send = { genre: $(this).data('genre') };
		
		$.ajax({
			beforeSend: function(){
				// Hide the install button
				$th.addClass('hide');
				
				// Show the loader
				$th.next('span').removeClass('hide');
			},
			type: "POST",
			url: "<?php echo URL::to('setup/utilities/ajax/install_genre');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				
				// Hide the loader
				$th.next('span').addClass('hide');
				
				if (data.code == 1)
				{
					// Update which label is shown
					$row.children('td:eq(1)').children('.label').addClass('hide');
					$row.children('td:eq(1)').children('.label-success').removeClass('hide');
					
					// Show the uninstall button
					$th.prev('button').removeClass('hide');
				}
				else
				{
					// Show the install button because it's failed
					$th.removeClass('hide');
				}
			}
		});
		
		return false;
	});
	
	$(document).on('click', '.js-do-uninstall', function(){
		
		var $row = $(this).parent().parent();
		var $th = $(this);
		var send = { genre: $(this).data('genre') };
		
		$.ajax({
			beforeSend: function(){
				
				// Hide the uninstall button
				$th.addClass('hide');
				
				// Show the loader
				$row.children('td:eq(2)').children('.loading').removeClass('hide');
			},
			type: "POST",
			url: "<?php echo URL::to('setup/utilities/ajax/uninstall_genre');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				
				// Hide the loader
				$row.children('td:eq(2)').children('.loading').addClass('hide');
				
				if (data.code == 1)
				{
					// Update which label is shown
					$row.children('td:eq(1)').children('.label').removeClass('hide');
					$row.children('td:eq(1)').children('.label-success').addClass('hide');
					
					// Show the install button
					$th.next('button').removeClass('hide');
				}
				else
				{
					// Show the uninstall button because it's failed
					$th.removeClass('hide');
				}
			}
		});
		
		return false;
	});
</script>