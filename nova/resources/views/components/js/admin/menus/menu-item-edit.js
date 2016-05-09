vue = {
	data: {
		link: "",
		menuId: false,
		oldType: "",
		pageId: "",
		title: "",
		type: false
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