{!! partial('include-angular') !!}
{!! HTML::script('nova/resources/js/angular/pageContents.js') !!}

<script>
	var baseUrl = "{{ Request::root() }}";

	$('.js-contentAction').click(function(e)
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