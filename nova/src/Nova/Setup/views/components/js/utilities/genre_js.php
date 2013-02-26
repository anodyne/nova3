<script type="text/javascript">
	$(document).ready(function(){
		
		$(document).on('click', '.do-install', function(){
			var $row = $(this).parent().parent();
			var $th = $(this);
			var send = { genre: $(this).attr('myGenre') };
			
			$.ajax({
				beforeSend: function(){
					// hide the install button
					$th.addClass('hide');
					
					// show the loader
					$th.next('span').removeClass('hide');
				},
				type: "POST",
				url: "<?php echo Uri::create('setup/utilityajax/install_genre');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					// hide the loader
					$th.next('span').addClass('hide');
					
					if (data.code == 1)
					{
						// update which label is shown
						$row.children('td:eq(1)').children('.label').addClass('hide');
						$row.children('td:eq(1)').children('.label-success').removeClass('hide');
						
						// show the uninstall button
						$th.prev('button').removeClass('hide');
					}
					else
					{
						// show the install button because it's failed
						$th.removeClass('hide');
					}
				}
			});
			
			return false;
		});
		
		$(document).on('click', '.do-uninstall', function(){
			var $row = $(this).parent().parent();
			var $th = $(this);
			var send = { genre: $(this).attr('myGenre') };
			
			$.ajax({
				beforeSend: function(){
					// hide the uninstall button
					$th.addClass('hide');
					
					// show the loader
					$row.children('td:eq(2)').children('.loading').removeClass('hide');
				},
				type: "POST",
				url: "<?php echo Uri::create('setup/utilityajax/uninstall_genre');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					// hide the loader
					$row.children('td:eq(2)').children('.loading').addClass('hide');
					
					if (data.code == 1)
					{
						// update which label is shown
						$row.children('td:eq(1)').children('.label').removeClass('hide');
						$row.children('td:eq(1)').children('.label-success').addClass('hide');
						
						// show the install button
						$th.next('button').removeClass('hide');
					}
					else
					{
						// show the uninstall button because it's failed
						$th.removeClass('hide');
					}
				}
			});
			
			return false;
		});
	});
</script>