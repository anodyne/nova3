<script src="{{ NOVAURL }}assets/js/jquery.ui.core.min.js"></script>
<script src="{{ NOVAURL }}assets/js/jquery.ui.widget.min.js"></script>
<script src="{{ NOVAURL }}assets/js/jquery.ui.mouse.min.js"></script>
<script src="{{ NOVAURL }}assets/js/jquery.ui.sortable.min.js"></script>
<script>

	$(document).ready(function()
	{
		// Activate the first tab
		$('.nav-tabs a:first').tab('show');

		// Makes the section list sortable and updates when the sort stops
		$('#sortableSections').sortable({
			stop: function(event, ui)
			{
				$.ajax({
					type: 'POST',
					url: "{{ URL::to('admin/form/ajax/update/form_section_order') }}",
					data: $(this).sortable('serialize')
				});
			}
		}).disableSelection();
	});

	// What action to take when a section action is clicked
	$(document).on('click', '.js-section-action', function(e)
	{
		e.preventDefault();

		var action = $(this).data('action');
		var id = $(this).data('id');

		if (action == 'delete')
		{
			$('#deleteSection').modal({
				remote: "{{ URL::to('admin/form/ajax/delete/form_section') }}/" + id
			}).modal('show');
		}
	});
	
</script>