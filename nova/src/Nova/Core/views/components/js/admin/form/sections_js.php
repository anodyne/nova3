<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.ui.sortable.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		// show the first tab
		$('.nav-tabs a:first').tab('show');

		// this fixes the issue where the row being dragged is compacted.
		var fixHelper = function(e, ui){
			ui.children().each(function(){
				$(this).width($(this).width());
			});
			
			return ui;
		};

		// makes the section list sortable and updates when the sort stops
		$('.sort-section tbody.sort-body').sortable({
			helper: fixHelper,
			stop: function(event, ui){
				
				$.ajax({
					type: 'POST',
					url: "<?php echo Uri::create('ajax/update/formsection_order');?>",
					data: $(this).sortable('serialize')
				});
			}
		}).disableSelection();

		// what action to take when a section action is clicked
		$(document).on('click', '.section-action', function(){
			var doaction = $(this).data('action');
			var id = $(this).data('id');

			if (doaction == 'delete')
			{
				$('<div/>').dialog2({
					title: "<?php echo ucwords(lang('short.delete', lang('section')));?>",
					content: "<?php echo Uri::create('ajax/delete/formsection');?>/" + id
				});
			}

			return false;
		});
	});
</script>