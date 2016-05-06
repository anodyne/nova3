vue = {
	methods: {
		duplicateRole: function (event) {
			var roleId = $(event.target).parent().data('id')

			$('#duplicateRole').modal({
				remote: novaUrl("admin/access/roles/" + roleId + "/duplicate")
			}).modal('show')
		},

		removeRole: function (event) {
			var roleId = $(event.target).parent().data('id')

			$('#removeRole').modal({
				remote: novaUrl("admin/access/roles/" + roleId + "/remove")
			}).modal('show')
		},

		usersWithRole: function (event) {
			var roleId = $(event.target).parent().data('id')
			
			$('#roleUsers').modal({
				remote: novaUrl("admin/access/roles/" + roleId + "/users")
			}).modal('show')
		}
	}
}