<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="{{ SRCURL }}assets/js/jquery.ui.sortable.min.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
		// This fixes the issue where the row being dragged is compacted.
		var fixHelper = function(e, ui){
			ui.children().each(function(){
				$(this).width($(this).width());
			});
			
			return ui;
		};

		// Makes the tab list sortable and updates when the sort stops
		$('#sortableTabs').sortable({
			helper: fixHelper,
			stop: function(event, ui){
				$.ajax({
					type: 'POST',
					url: "{{ URL::to('ajax/update/form_tab_order') }}",
					data: $(this).sortable('serialize')
				});
			}
		}).disableSelection();

		// Populate the link_id field when the name changes
		$('[name="name"]').change(function(){
			if ($('[name="link_id"]').val() == "")
			{
				var value = $(this).val();
				value = value.replace(/\s+/g, '');
				$('[name="link_id"]').val(value);
			}
		});
	});

	// What action to take when a tab action is clicked
	$(document).on('click', '.js-tab-action', function(e){
		var action = $(this).data('action');
		var id = $(this).data('id');

		if (action == 'delete')
		{
			$('#deleteTab').modal({
				remote: "{{ URL::to('ajax/delete/form_tab') }}/" + id
			}).modal('show');
		}

		e.preventDefault();
	});

</script>