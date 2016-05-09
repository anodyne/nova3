vue = {
	methods: {
		removeEntry: function (event) {
			var entryId = $(event.target).parent().data('id')
			var formKey = $(event.target).parent().data('form-key')

			$('#removeFormEntry').modal({
				remote: novaUrl("admin/form-center/" + formKey + "/remove/" + entryId)
			}).modal('show')
		}
	}
}