{!! HTML::script('nova/resources/uikit/js/core/core.min.js') !!}
{!! HTML::script('nova/resources/uikit/js/components/nestable.min.js') !!}
<script>
	$(document).on('change.uk.nestable', '.uk-nestable', function (event, item, action)
	{
		// Start with an empty array for storing information
		var positions = [];
		positions[0] = [];

		// Step through all of the top level menu items
		$('#menu > li[data-id]').each(function (mainIndex, mainElement)
		{
			var mainId = $(this).data('id');

			positions[0].push(mainId);
			positions[mainId] = [];

			// Now step through any lower level menu items for
			// this specific top level menu item
			$('#menu > li[data-id="' + mainId + '"] > ul > li[data-id]').each(function()
			{
				positions[mainId].push($(this).data('id'));
			});
		});

		$.ajax({
			url: "{{ route('admin.menus.reorder') }}",
			type: "POST",
			dataType: "json",
			data: {
				"menu": $('#menu').data('menu'),
				"positions": positions
			}
		});
	});

	$('.js-menuItemAction').click(function(e)
	{
		e.preventDefault();

		var itemId = $(this).data('id');
		var action = $(this).data('action');

		if (action == 'remove')
		{
			$('#removeMenuItem').modal({
				remote: "{{ url('admin/menu-items') }}/" + itemId + "/remove"
			}).modal('show');
		}
	});
</script>