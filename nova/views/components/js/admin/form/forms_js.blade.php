<script>

	$(document).ready(function()
	{
		$('#searchForms').quicksearch('#formsSearch .thumbnail');
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

</script>