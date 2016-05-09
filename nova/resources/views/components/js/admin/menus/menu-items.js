vue = {
	methods: {
		createItemDivider: function (event) {
			var url = Nova.data.storeDividerUrl
			var data = {
				menu: $(event.target).parent().data('menu')
			}

			this.$http.post(url, data).then(response => {
				if (response.data.code == 1) {
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
			}, response => {
				swal({
					title: "Error!",
					text: "There was an error trying to create the menu item divider. Please try again. (Error " + response.status + ")",
					type: "error",
					timer: null,
					html: true
				})
			})
		},

		removeMenuItem: function (event) {
			var itemId = $(event.target).data('id')

			$('#removeMenuItem').modal({
				remote: novaUrl("admin/menu-items/" + itemId + "/remove")
			}).modal('show')
		}
	}
}

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
		url: Nova.data.reorderUrl,
		data: {
			menu: $('#menu').data('menu'),
			positions: positions
		},
		type: "POST"
	})
})