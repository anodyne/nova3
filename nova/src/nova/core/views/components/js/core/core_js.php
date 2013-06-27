<!--[if lt IE 9]>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
	<script src="http://code.jquery.com/jquery-2.0.2.min.js"></script>
<!--<![endif]-->

<script type="text/javascript" src="<?php echo SRCURL;?>assets/js/jquery.lazy.js"></script>
<script type="text/javascript" src="<?php echo SRCURL;?>assets/js/bootstrap.min.js"></script>
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
		$('.popover-right').popover({
			placement: 'right',
			html: true
		});
		$('.popover-left').popover({
			placement: 'left',
			html: true
		});
		$('.popover-top').popover({
			placement: 'top',
			html: true
		});
		$('.popover-bottom').popover({
			placement: 'bottom',
			html: true
		});

		$.lazy({
			src: "<?php echo URL::to('nova/src/nova/assets/js/typeahead.min.js');?>",
			name: 'typeahead',
			dependencies: {
				css: ["<?php echo URL::to('nova/src/nova/assets/css/typeahead.bootstrap.css');?>"]
			},
			cache: true
		});
	});

	// Rank dropdown
	$('#rankDrop').on('change', function(){
		$.ajax({
			type: "GET",
			url: "<?php echo URL::to('ajax/get/rank');?>/" + $('#rankDrop option:selected').val() + "/image",
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
			type: "GET",
			url: "<?php echo URL::to('ajax/get/position');?>/" + $('#positionDrop option:selected').val() + "/desc",
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
	$('.modal').on('hidden.bs.modal', function(){
		$('.modal').removeData('bs.modal');
	});

</script>