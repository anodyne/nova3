<script src="{{ URL::to('nova/assets/js/jquery.quicksearch.min.js') }}"></script>
<script>

	$(document).on('keyup', '#searchForms', function()
	{
		if ($(this).val() != "")
			$('#searchComplete').removeClass('hidden');
		else
			$('#searchComplete').addClass('hidden');
	});

	$('#searchForms').quicksearch('#formsSearch > div', {
		hide: function()
		{
			$(this).addClass('hidden');
		},
		show: function()
		{
			$(this).removeClass('hidden');
		}
	});

	// Populate the form key field when the name changes
	$(document).on('change', '.js-name-change', function()
	{
		if ($('[name="key"]').val() == "")
		{
			var value = $(this).val();
			value = value.replace(/\s+/g, '');
			$('[name="key"]').val(value);
		}
	});
	
	$(document).on('click', '.js-form-action', function(e)
	{
		e.preventDefault();

		var key = $(this).data('key');
		var action = $(this).data('action');

		if (action == 'delete')
		{
			$('#deleteForm').modal({
				remote: "{{ URL::to('admin/form/ajax/delete/form') }}/" + key
			}).modal('show');
		}
	});

	$(document).on('click', '.js-clear-search', function(e)
	{
		e.preventDefault();

		// Reset the search field
		$('#searchForms').val('').text('');

		// Make sure everything is shown
		$('#formsSearch').children().each(function()
		{
			$(this).removeClass('hidden');
		});

		// Hide the button
		$(this).addClass('hidden');
	});

</script>