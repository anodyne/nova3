vue = {
	mounted () {
		Sortable.create(document.getElementById('sortable'), {
			handle: '.sortable-handle',
			onEnd (event) {
				handleOnEnd(event)
			}
		})

		$('.sub-sortable').each(function () {
			Sortable.create(this, {
				handle: '.sortable-handle',
				group: {
					name: $(this).data('group'),
					pull: false,
					put: true
				},
				onEnd (event) {
					handleOnEnd(event)
				}
			})
		})
	}
}

function handleOnEnd (event) {
	let order = new Array()

	$(event.from).children().each(function () {
		let id = $(this).data('id')

		if (id) {
			order.push(id)
		}
	})

	axios.patch(route('departments.reorder'), {
		depts: order
	})
}