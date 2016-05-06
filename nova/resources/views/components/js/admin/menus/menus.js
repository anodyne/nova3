vue = {
	methods: {
		removeMenu: function (event) {
			var menuId = $(event.target).parent().data('id')

			$('#removeMenu').modal({
				remote: novaUrl("admin/menus/" + menuId + "/remove")
			}).modal('show')
		}
	}
}