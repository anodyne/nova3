<script type="text/javascript" src="<?php echo Uri::base(false);?>/nova/modules/assets/js/jquery.ajaxq.js"></script>
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
		
		$('input[name=upgrade_characters_users]').change(function(){
			var checked = $('input[name=upgrade_characters_users]:checked').val();
			
			if (checked == 0)
			{
				$('input[name=upgrade_logs]:nth(1)').attr("checked", true);
				$('input[name=upgrade_logs]').attr("disabled", "disabled");
				
				$('input[name=upgrade_news]:nth(1)').attr("checked", true);
				$('input[name=upgrade_news]').attr("disabled", "disabled");
				
				$('input[name=upgrade_missions]:nth(1)').attr("checked", true);
				$('input[name=upgrade_missions]').attr("disabled", "disabled");
			}
			
			if (checked == 1)
			{
				$('input[name=upgrade_logs]:nth(0)').attr("checked", true);
				$('input[name=upgrade_logs]').attr("disabled", "");
				
				$('input[name=upgrade_news]:nth(0)').attr("checked", true);
				$('input[name=upgrade_news]').attr("disabled", "");
				
				$('input[name=upgrade_missions]:nth(0)').attr("checked", true);
				$('input[name=upgrade_missions]').attr("disabled", "");
			}
		});
		
		$(document).on('click', '#start', function(){
			// characters and users
			if ($('input[name=upgrade_characters_users]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(0) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_characters');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(0) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(0) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(0) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(0) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(0) td:eq(0) .errors').removeClass('hide');
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(0) td:eq(1) .warning').removeClass('hide');
							$('table tbody tr:eq(0) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(0) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			// awards
			if ($('input[name=upgrade_awards]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(1) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_awards');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(1) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(1) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(1) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(1) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(1) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			// settings and messages
			if ($('input[name=upgrade_settings]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(2) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_settings');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(2) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(2) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(2) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(2) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(2) td:eq(0) .errors').removeClass('hide');
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(2) td:eq(1) .warning').removeClass('hide');
							$('table tbody tr:eq(2) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(2) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			// personal logs
			if ($('input[name=upgrade_logs]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(3) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_logs');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(3) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(3) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(3) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(3) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(3) td:eq(0) .errors').removeClass('hide');
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(3) td:eq(1) .warning').removeClass('hide');
							$('table tbody tr:eq(3) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(3) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			// news categories and items
			if ($('input[name=upgrade_news]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(4) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_news');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(4) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(4) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(4) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(4) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(4) td:eq(0) .errors').removeClass('hide');
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(4) td:eq(1) .warning').removeClass('hide');
							$('table tbody tr:eq(4) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(4) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			// missions and mission posts
			if ($('input[name=upgrade_missions]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(5) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_missions');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(5) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(5) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(5) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(5) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(5) td:eq(0) .errors').removeClass('hide');
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(5) td:eq(1) .warning').removeClass('hide');
							$('table tbody tr:eq(5) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(5) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			// specs
			if ($('input[name=upgrade_specs]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(6) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_specs');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(6) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(6) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(6) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(6) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(6) td:eq(0) .errors').removeClass('hide');
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(6) td:eq(1) .warning').removeClass('hide');
							$('table tbody tr:eq(6) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(6) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			// tour items
			if ($('input[name=upgrade_tour]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(7) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_tour');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(7) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(7) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(7) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(7) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(7) td:eq(0) .errors').removeClass('hide');
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(7) td:eq(1) .warning').removeClass('hide');
							$('table tbody tr:eq(7) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(7) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			// docking items
			if ($('input[name=upgrade_docking]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(8) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_docking');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(8) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(8) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(8) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(8) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(8) td:eq(0) .errors').removeClass('hide');
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(8) td:eq(1) .warning').removeClass('hide');
							$('table tbody tr:eq(8) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(8) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			// wiki pages
			if ($('input[name=upgrade_wiki]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(9) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_wiki');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(9) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(9) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(9) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(9) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(9) td:eq(0) .errors').removeClass('hide');
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(9) td:eq(1) .warning').removeClass('hide');
							$('table tbody tr:eq(9) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(9) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			// uploads
			if ($('input[name=upgrade_uploads]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(10) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_uploads');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(10) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(10) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(10) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(10) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(10) td:eq(0) .errors').removeClass('hide');
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(10) td:eq(1) .warning').removeClass('hide');
							$('table tbody tr:eq(10) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(10) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			// private messages
			if ($('input[name=upgrade_pm]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(11) td:eq(1) .loading').removeClass('hide');
					},
					type: "POST",
					url: "<?php echo Uri::create('setup/upgradeajax/upgrade_private_messages');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(11) td:eq(1) .loading').addClass('hide');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(11) td:eq(1) .success').removeClass('hide');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(11) td:eq(1) .failure').removeClass('hide');
							$('table tbody tr:eq(11) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(11) td:eq(0) .errors').removeClass('hide');
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(11) td:eq(1) .warning').removeClass('hide');
							$('table tbody tr:eq(11) td:eq(0) .errors .errors-content').html(data.message);
							$('table tbody tr:eq(11) td:eq(0) .errors').removeClass('hide');
						}
					}
				});
			}
			
			$('#start').ajaxStop(function(){
				
				// change the button
				$(this).attr('id', 'next').html('Next Step');

				// change the indicator
				$('#steps').each(function(){

					// change from active to complete
					if ($(this).hasClass('step-active'))
					{
						$(this).removeClass('step-active').addClass('step-complete');
					}
				});
 			});
			
			return false;
		});
	});
</script>