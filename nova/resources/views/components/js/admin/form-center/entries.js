vue = {
	methods: {
		removeEntry: function (event) {
			var parent = $(event.target).parent()
			var entryId = parent.data('id')
			var formKey = parent.data('form-key')

			$('#removeFormEntry').modal({
				remote: novaUrl("admin/form-center/" + formKey + "/remove/" + entryId)
			}).modal('show')
		}
	}
}