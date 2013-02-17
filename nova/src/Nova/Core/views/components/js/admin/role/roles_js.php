<script type="text/javascript">
	
	$(document).on('click', '.role-action', function(){
		var doaction = $(this).data('action');
		var id = $(this).data('id');

		if (doaction == 'delete')
		{
			$('<div/>').dialog2({
				title: "<?php echo ucwords(lang('short.delete', lang('role')));?>",
				content: "<?php echo Uri::create('ajax/delete/role');?>/" + id
			});
		}

		if (doaction == 'duplicate')
		{
			$('<div/>').dialog2({
				title: "<?php echo ucwords(lang('short.duplicate', lang('role')));?>",
				content: "<?php echo Uri::create('ajax/add/role_duplicate');?>/" + id
			});
		}

		if (doaction == 'view')
		{
			$('<div/>').dialog2({
				title: "<?php echo ucwords(langConcat('users with this role'));?>",
				content: "<?php echo Uri::create('ajax/info/role_users');?>/" + id
			});
		}

		return false;
	});
</script>