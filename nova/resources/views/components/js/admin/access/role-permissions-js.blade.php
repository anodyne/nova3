{!! partial('include-angular') !!}
{!! HTML::script('nova/resources/js/angular/rolePermissions.js') !!}

<script>
	var baseUrl = "{{ Request::root() }}";

	$(document).on('click', '.js-permissionAction', function(e)
	{
		e.preventDefault();

		var permissionId = $(this).data('id');
		var action = $(this).data('action');

		if (action == 'remove')
		{
			$('#removePermission').modal({
				remote: "{{ url('admin/access/permissions') }}/" + permissionId + "/remove"
			}).modal('show');
		}
	});
</script>