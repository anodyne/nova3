vue = {
	data: {
		access: [],
		accessRole: [],
		accessType: "",
		link: "",
		menuId: false,
		pageId: "",
		title: "",
		type: false,

		roles: Nova.data.roles,
		permissions: Nova.data.permissions
	},

	watch: {
		"accessType": function (value, oldValue) {
			if (value == "") {
				this.access = []
				this.accessRole = []
			}
		},

		"accessRole": function (value, oldValue) {
			this.access = value
		},

		"type": function (value, oldValue) {
			if (value != "" && value != oldValue) {
				this.link = ""
				this.pageId = ""
			}
		}
	}
}