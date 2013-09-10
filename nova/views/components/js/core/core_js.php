<?php include_once NOVAPATH.'views/components/js/core/jquery_js.php';?>

<script src="<?php echo NOVAURL;?>assets/js/jquery.lazy.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script>
	
	$(document).ready(function()
	{
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
			src: "<?php echo URL::to('nova/assets/js/typeahead.min.js');?>",
			name: 'typeahead',
			cache: true
		});
	});

	// Rank dropdown
	$('#rankDrop').on('change', function(e)
	{
		$.ajax({
			type: "GET",
			url: "<?php echo URL::to('ajax/get/rank');?>/" + $('#rankDrop option:selected').val() + "/image",
			success: function(data){
				$('#rankImg').html('');
				$('#rankImg').append(data);
			}
		});
		
		e.preventDefault();
	});

	// Position dropdown
	$('#positionDrop').on('change', function()
	{
		$.ajax({
			type: "GET",
			url: "<?php echo URL::to('ajax/get/position');?>/" + $('#positionDrop option:selected').val() + "/desc",
			beforeSend: function()
			{
				$('#positionLoader').removeClass('hide');
			},
			success: function(data)
			{
				$('#positionDescInner').html('');
				$('#positionDescInner').append(data);
				$('#positionLoader').addClass('hide');
			}
		});
		
		e.preventDefault();
	});

	// Access role dropdown
	$('#roleDrop').on('change', function()
	{
		$.ajax({
			type: "POST",
			url: "<?php echo URL::to('ajax/info/role_desc');?>",
			data: { role: $('#roleDrop option:selected').val() },
			success: function(data){
				$('#roleDesc').html('');
				$('#roleDesc').append(data);
			}
		});
		
		e.preventDefault();
	});

	// Destroy all modals when they're hidden
	$('.modal').on('hidden.bs.modal', function()
	{
		$('.modal').removeData('bs.modal');
	});

</script>