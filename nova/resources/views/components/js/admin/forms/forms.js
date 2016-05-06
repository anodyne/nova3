vue = {
	methods: {
		removeForm: function (event) {
			var formKey = $(event.target).parent().data('form-key')

			$('#removeForm').modal({
				remote: novaUrl("admin/forms/" + formKey + "/remove")
			}).modal('show')
		}
	}
}