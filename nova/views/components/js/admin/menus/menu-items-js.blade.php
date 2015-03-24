{!! HTML::script('nova/assets/uikit/js/core/core.min.js') !!}
{!! HTML::script('nova/assets/uikit/js/components/nestable.min.js') !!}
<script>
	$(document).on('change.uk.nestable', '.uk-nestable', function (event, item, action)
	{
		// Start with some empty arrays for storing information
		var mainMenuPositions = [];
		var subMenuPositions = [];

		// Step through all of the top level menu items
		$('#menu > li[data-id]').each(function (mainIndex, mainElement)
		{
			var mainId = $(this).data('id');
			
			mainMenuPositions.push(mainId);
			subMenuPositions[mainId] = [];

			// Now step through any lower level menu items for
			// this specific top level menu item
			$('#menu > li[data-id="' + mainId + '"] > ul > li[data-id]').each(function (subIndex, subElement)
			{
				subMenuPositions[mainId].push($(this).data('id'));
			});
		});

		$.ajax({
			url: "{{ route('admin.menus.reorder') }}",
			type: "POST",
			dataType: "json",
			data: {
				"mainMenuPositions": mainMenuPositions,
				"subMenuPositions": subMenuPositions,
				"menu": $('#menu').data('menu')
			}
		});
	});
</script>