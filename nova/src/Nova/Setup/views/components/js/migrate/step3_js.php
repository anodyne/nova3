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
		
		$(document).on('click', '#start', function(){
			
			$.ajaxq('queue', {
				beforeSend: function(){
					$('input[name=password]').next().show();
				},
				type: "POST",
				url: "<?php echo Uri::create('setup/upgradeajax/setup_password');?>",
				data: { 'password': $('input[name=password]').val() },
				dataType: 'json',
				success: function(data){
					$('input[name=password]').next().hide();
					$('#password-success').show();
				}
			});
			
			$.ajaxq('queue', {
				beforeSend: function(){
					$('input[name=admins]').next().show();
				},
				type: "POST",
				url: "<?php echo Uri::create('setup/upgradeajax/setup_admins');?>",
				data: { 'admins': $('select[name=admins]').val() },
				dataType: 'json',
				success: function(data){
					$('input[name=admins]').next().hide();
					$('#admins-success').show();
				}
			});
			
			$('#start').ajaxStop(function(){
				
				// change the button
				$(this).attr('id', 'next').html('Finish');

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