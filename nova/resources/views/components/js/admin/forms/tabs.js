vue = {
	methods: {
		removeTab: function (event) {
			var formKey = $(event.target).data('form-key')
			var tabId = $(event.target).data('id')

			$('#removeTab').modal({
				remote: novaUrl("admin/forms/" + formKey + "/tabs/" + tabId + "/remove")
			}).modal('show')
		}
	}
}

Sortable.create(byId("sortable"), {
	handle: ".sortable-handle",
	onEnd: function (event) {
		var tabOrder = []

		$(event.from).children().each(function () {
			tabOrder.push($(this).data('id'))
		})

		var url = Nova.data.orderUpdateUrl
		var data = {
			tabs: tabOrder
		}

		this.$http.post(url, data)
	}
})