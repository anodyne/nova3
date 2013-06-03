<script type="text/javascript">
	$(document).on('click', '.js-form-action', function(e){
		var key = $(this).data('key');
		var action = $(this).data('action');

		if (action == 'update')
		{
			$('#updateForm').modal({
				remote: "{{ URL::to('ajax/update/form') }}/" + key
			}).modal('show');
		}

		if (action == 'create')
		{
			$('#createForm').modal({
				remote: "{{ URL::to('ajax/update/form') }}/" + key
			}).modal('show');
		}

		e.preventDefault();
	});
</script>