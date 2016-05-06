vue = {
	methods: {
		removeSection: function (event) {
			var formKey = $(event.target).parent().data('form-key')
			var sectionId = $(event.target).parent().data('id')

			$('#removeSection').modal({
				remote: novaUrl("admin/forms/" + formKey + "/sections/" + sectionId + "/remove")
			}).modal('show')
		}
	}
}

$('.data-table').each(function () {
	Sortable.create(this, {
		handle: '.sortable-handle',
		onEnd: function (event) {
			var sectionOrder = []

			$(event.from).children().each(function () {
				sectionOrder.push($(this).data('id'))
			})

			var url = Nova.data.orderUpdateUrl
			var data = {
				sections: sectionOrder
			}

			this.$http.post(url, data)
		}
	})
})