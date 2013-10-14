<script src="{{ NOVAURL }}assets/js/jquery.ui.core.min.js"></script>
<script src="{{ NOVAURL }}assets/js/jquery.ui.widget.min.js"></script>
<script src="{{ NOVAURL }}assets/js/jquery.ui.mouse.min.js"></script>
<script src="{{ NOVAURL }}assets/js/jquery.ui.sortable.min.js"></script>
<script>
	
	$(document).ready(function()
	{
		// Makes the tab list sortable and updates when the sort stops
		$('#sortableTabs').sortable({
			stop: function(event, ui)
			{
				$.ajax({
					type: 'POST',
					url: "{{ URL::to('admin/form/ajax/update/form_tab_order') }}",
					data: $(this).sortable('serialize')
				});
			}
		}).disableSelection();
	});

	// Populate the link_id field when the name changes
	$(document).on('change', '.js-name-change', function()
	{
		if ($('[name="link_id"]').val() == "")
		{
			var value = $(this).val();
			value = value.replace(/\s+/g, '');
			$('[name="link_id"]').val(value);
		}
	});

	// What action to take when a tab action is clicked
	$(document).on('click', '.js-tab-action', function(e)
	{
		e.preventDefault();

		var action = $(this).data('action');
		var id = $(this).data('id');

		if (action == 'delete')
		{
			$('#deleteTab').modal({
				remote: "{{ URL::to('admin/form/ajax/delete/form_tab') }}/" + id
			}).modal('show');
		}
	});

</script>