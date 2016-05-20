vue = {
	data: {
		link: "",
		menuId: false,
		oldType: "",
		pageId: "",
		title: "",
		type: false,

		roles: Nova.data.roles,
		permissions: Nova.data.permissions
	},

	methods: {
		resetTypeFields: function () {
			if (this.type != this.oldType) {
				this.link = ""
				this.pageId = ""
			}
		}
	},

	ready: function () {
		this.oldType = this.type
	}
}