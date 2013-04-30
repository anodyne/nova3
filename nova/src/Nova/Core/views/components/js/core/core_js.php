<!--[if lt IE 9]>
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
	<script src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<!--<![endif]-->

<script type="text/javascript" src="<?php echo SRCURL;?>Assets/js/jquery.lazy.js"></script>
<script type="text/javascript" src="<?php echo SRCURL;?>Assets/js/bootstrap.min.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
		/**
		 * Bootstrap Tooltips
		 */
		$('.tooltip-right').tooltip({
			placement: 'right',
			container: 'body',
			html: true
		});
		$('.tooltip-left').tooltip({
			placement: 'left',
			container: 'body',
			html: true
		});
		$('.tooltip-top').tooltip({
			placement: 'top',
			container: 'body',
			html: true
		});
		$('.tooltip-bottom').tooltip({
			placement: 'bottom',
			container: 'body',
			html: true
		});

		/**
		 * Bootstrap Popovers
		 */
		$('.popover-right').tooltip({
			placement: 'right',
			html: true
		});
		$('.popover-left').tooltip({
			placement: 'left',
			html: true
		});
		$('.popover-top').tooltip({
			placement: 'top',
			html: true
		});
		$('.popover-bottom').tooltip({
			placement: 'bottom',
			html: true
		});
	});

	// Rank dropdown
	$('#rankDrop').on('change', function(){
		$.ajax({
			type: "POST",
			url: "<?php echo URL::to('ajax/info/rank_image');?>",
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

	// Position dropdown
	$('#positionDrop').on('change', function(){
		$.ajax({
			type: "POST",
			url: "<?php echo URL::to('ajax/info/position_desc');?>",
			data: { position: $('#positionDrop option:selected').val() },
			success: function(data){
				$('#positionDesc').html('');
				$('#positionDesc').append(data);
			}
		});
		
		return false;
	});

	// Access role dropdown
	$('#roleDrop').on('change', function(){
		$.ajax({
			type: "POST",
			url: "<?php echo URL::to('ajax/info/role_desc');?>",
			data: { role: $('#roleDrop option:selected').val() },
			success: function(data){
				$('#roleDesc').html('');
				$('#roleDesc').append(data);
			}
		});
		
		return false;
	});

	// Destroy all modals when they're hidden
	$('body').on('hidden', '.modal', function(){
		$(this).removeData('modal');
	});

</script>