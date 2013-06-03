<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.sortable.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		// Show the first tab
		$('.nav-tabs a:first').tab('show');

		// This fixes the issue where the row being dragged is compacted.
		var fixHelper = function(e, ui){
			ui.children().each(function(){
				$(this).width($(this).width());
			});
			
			return ui;
		};

		// Makes the section list sortable and updates when the sort stops
		$('.sort-section tbody.sort-body').sortable({
			helper: fixHelper,
			stop: function(event, ui){
				$.ajax({
					type: 'POST',
					url: "{{ URL::to('ajax/update/formsection_order') }}",
					data: $(this).sortable('serialize')
				});
			}
		}).disableSelection();

		// What action to take when a section action is clicked
		$(document).on('click', '.js-section-action', function(){
			var doaction = $(this).data('action');
			var id = $(this).data('id');

			if (doaction == 'delete')
			{
				//
			}

			return false;
		});
	});
</script>