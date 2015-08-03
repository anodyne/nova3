{!! partial('include-angular') !!}
{!! HTML::script('nova/resources/js/angular/pages.js') !!}

<script>
	var baseUrl = "{{ Request::root() }}";

	$('.js-pageAction').click(function(e)
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