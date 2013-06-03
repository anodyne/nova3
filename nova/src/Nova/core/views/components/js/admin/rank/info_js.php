<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.sortable.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		// this fixes the issue where the row being dragged is compacted.
		var fixHelper = function(e, ui){
			ui.children().each(function(){
				$(this).width($(this).width());
			});
			
			return ui;
		};

		// makes the rank info list sortable and updates when the sort stops
		$('.sort-rankinfo tbody.sort-body').sortable({
			helper: fixHelper,
			stop: function(event, ui){
				
				$.ajax({
					type: 'POST',
					url: "<?php echo Uri::create('ajax/update/rankinfo_order');?>",
					data: $(this).sortable('serialize')
				});
			}
		}).disableSelection();

		// what action to take when a rank info action is clicked
		$(document).on('click', '.rankinfo-action', function(){
			var doaction = $(this).data('action');
			var id = $(this).data('id');

			if (doaction == 'delete')
			{
				$('<div/>').dialog2({
					title: "<?php echo ucwords(lang('short.delete', langConcat('rank info')));?>",
					content: "<?php echo Uri::create('ajax/delete/rankinfo');?>/" + id
				});
			}

			if (doaction == 'update')
			{
				$('<div/>').dialog2({
					title: "<?php echo ucwords(lang('short.update', langConcat('rank info')));?>",
					content: "<?php echo Uri::create('ajax/update/rankinfo');?>/" + id
				});
			}

			if (doaction == 'create')
			{
				$('<div/>').dialog2({
					title: "<?php echo ucwords(lang('short.create', langConcat('rank info')));?>",
					content: "<?php echo Uri::create('ajax/add/rankinfo');?>"
				});
			}

			return false;
		});
	});
</script>