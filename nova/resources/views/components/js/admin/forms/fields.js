vue = {
	methods: {
		removeField: function (event) {
			var parent = $(event.target).parent()
			var formKey = parent.data('form-key')
			var fieldId = parent.data('id')

			$('#removeField').modal({
				remote: novaUrl("admin/forms/" + formKey + "/fields/" + fieldId + "/remove")
			}).modal('show')
		}
	},

	ready: function () {
		$('.nav-tabs').each(function () {
			$(this).find('li a:first').tab('show')
		})

		$('.nav-pills').each(function () {
			$(this).find('li a:first').tab('show')
		})
		
		$.each(byClass("sortable"), function () {
			Sortable.create(this, {
				handle: ".sortable-handle",
				onEnd: function (event) {
					var fieldOrder = new Array()

					$(event.from).children().each(function () {
						fieldOrder.push($(this).data('id'))
					})

					var url = Nova.data.orderUpdateUrl
					var data = {
						fields: fieldOrder
					}

					this.$http.post(url, data)
				}
			})
		})
	}
}