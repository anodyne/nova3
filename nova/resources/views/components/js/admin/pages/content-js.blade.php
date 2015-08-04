{!! partial('include-angular') !!}
{!! HTML::script('nova/resources/js/angular/pageContents.js') !!}

<script>
	var baseUrl = "{{ Request::root() }}";

	$(document).on('click', '.js-contentAction', function(e)
	{
		e.preventDefault();

		var contentId = $(this).data('id');
		var action = $(this).data('action');

		if (action == 'remove')
		{
			$('#removeContent').modal({
				remote: "{{ url('admin/content') }}/" + contentId + "/remove"
			}).modal('show');
		}
	});
</script>