<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.js"></script>
{!! HTML::script('nova/resources/js/angular/rolePermissions.js') !!}

<script>
	var baseUrl = "{{ Request::root() }}";

	$('.js-permissionAction').click(function(e)
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