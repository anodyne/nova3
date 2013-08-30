<script type="text/javascript">
	$('.status-toggle').on('click', function(){

		var status = $(this).data('status');

		if (status == 'inprogress')
		{
			$('.status-<?php echo Status::IN_PROGRESS;?>').show();
			$('.status-<?php echo Status::APPROVED;?>').hide();
			$('.status-<?php echo Status::REJECTED;?>').hide();
		}

		if (status == 'approved')
		{
			$('.status-<?php echo Status::APPROVED;?>').show();
			$('.status-<?php echo Status::IN_PROGRESS;?>').hide();
			$('.status-<?php echo Status::REJECTED;?>').hide();
		}

		if (status == 'rejected')
		{
			$('.status-<?php echo Status::REJECTED;?>').show();
			$('.status-<?php echo Status::APPROVED;?>').hide();
			$('.status-<?php echo Status::IN_PROGRESS;?>').hide();
		}

		if (status == 'all')
		{
			$('.status-<?php echo Status::IN_PROGRESS;?>').show();
			$('.status-<?php echo Status::APPROVED;?>').show();
			$('.status-<?php echo Status::REJECTED;?>').show();
		}
	});

	$('.ban-user').on('click', function(){

		var user = $(this).data('user');

		$('<div/>').dialog2({
			title: "<?php echo ucwords(langConcat('action.ban user'));?>",
			content: "<?php echo Uri::create('ajax/add/arc_banuser');?>/" + user
		});

		return false;
	});

	$('.unban-user').on('click', function(){

		var user = $(this).data('user');

		$('<div/>').dialog2({
			title: "<?php echo ucwords(langConcat('action.remove ban'));?>",
			content: "<?php echo Uri::create('ajax/delete/arc_unbanuser');?>/" + user
		});

		return false;
	});
</script>