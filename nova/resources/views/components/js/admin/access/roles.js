vue = {
	methods: {
		duplicateRole: function (event) {
			$('#duplicateRole').modal({
				remote: novaUrl("admin/access/roles/" + $(event.target).data('id') + "/duplicate")
			}).modal('show')
		},

		removeRole: function (event) {
			$('#removeRole').modal({
				remote: novaUrl("admin/access/roles/" + $(event.target).data('id') + "/remove")
			}).modal('show')
		},

		usersWithRole: function (event) {
			$('#roleUsers').modal({
				remote: novaUrl("admin/access/roles/" + $(event.target).data('id') + "/users")
			}).modal('show')
		}
	}
}