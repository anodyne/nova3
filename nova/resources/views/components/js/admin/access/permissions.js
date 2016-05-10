vue = {
	data: {
		permissions: Nova.data.permissions,
		search: ""
	},

	methods: {
		permissionRoles: function (roles) {
			var output = []

			for (var r = 0; r < roles.length; r++) {
				output.push(roles[r].name)
			}

			return output.join(',')
		},

		removePermission: function (permissionId) {
			$('#removePermission').modal({
				remote: novaUrl("admin/access/permissions/" + permissionId + "/remove")
			}).modal('show')
		},

		resetFilters: function () {
			this.search = ""
		}
	}
}