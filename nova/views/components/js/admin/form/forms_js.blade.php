<script type="text/javascript">

	$(document).ready(function(){
		$('#searchForms').quicksearch('#formsSearch .thumbnail');

		// Populate the form key field when the name changes
		$('[name="name"]').change(function(){
			if ($('[name="key"]').val() == "")
			{
				var value = $(this).val();
				value = value.replace(/\s+/g, '');
				$('[name="key"]').val(value);
			}
		});
	});
	
	$(document).on('click', '.js-form-action', function(e){
		var key = $(this).data('key');
		var action = $(this).data('action');

		if (action == 'delete')
		{
			$('#deleteForm').modal({
				remote: "{{ URL::to('ajax/delete/form') }}/" + key
			}).modal('show');
		}

		e.preventDefault();
	});

</script>