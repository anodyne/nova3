<script type="text/javascript">

	$(document).ready(function(){
		$('#searchForms').quicksearch('#formsSearch .thumbnail');
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