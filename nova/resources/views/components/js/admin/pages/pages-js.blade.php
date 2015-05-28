<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.js"></script>
{!! HTML::script('nova/resources/js/angular/pages.js') !!}

<script>
	var baseUrl = "{{ Request::root() }}";

	$(document).on('click', '.js-pageAction', function(e)
	{
		e.preventDefault();

		var pageId = $(this).data('id');
		var action = $(this).data('action');

		if (action == 'remove')
		{
			$('#removePage').modal({
				remote: "{{ url('admin/pages') }}/" + pageId + "/remove"
			}).modal('show');
		}
	});
</script>