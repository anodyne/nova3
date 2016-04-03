{!! HTML::script('nova/resources/js/uikit/core/core.min.js') !!}
{!! HTML::script('nova/resources/js/uikit/components/nestable.min.js') !!}
<script>
	$('.uk-nestable').on('change.uk.nestable', function (event, item, action) {
		// Start with an empty array for storing information
		var positions = [];
		positions[0] = [];

		// Step through all of the top level menu items
		$('#menu > li[data-id]').each(function (mainIndex, mainElement) {
			var mainId = $(this).data('id')

			positions[0].push(mainId)
			positions[mainId] = []

			// Now step through any lower level menu items for
			// this specific top level menu item
			$('#menu > li[data-id="' + mainId + '"] > ul > li[data-id]').each(function () {
				positions[mainId].push($(this).data('id'))
			})
		})

		$.ajax({
			url: "{{ route('admin.menu.items.reorder') }}",
			type: "POST",
			dataType: "json",
			data: {
				menu: $('#menu').data('menu'),
				positions: positions
			}
		})
	})

	$('.js-menuItemAction').click(function (e) {
		e.preventDefault()

		var itemId = $(this).data('id')
		var action = $(this).data('action')

		if (action == 'remove') {
			$('#removeMenuItem').modal({
				remote: "{{ url('admin/menu-items') }}/" + itemId + "/remove"
			}).modal('show')
		}
	})

	$('.js-createMenuItemDivider').click(function (e) {
		e.preventDefault()

		var handler = $(this)

		$.ajax({
			url: "{{ route('admin.menus.items.storeDivider') }}",
			type: "POST",
			dataType: "json",
			data: { menu: handler.data('menu') },
			success: function (data) {
				if (data.code == 1) {
					location.reload(true)
				} else {
					swal({
						title: "Error!",
						text: data.message,
						type: 'error',
						html: true,
						timer: null
					})
				}
			}
		})
	})
</script>