vue = {
	data: {
		link: "",
		menuId: false,
		pageId: "",
		title: "",
		type: false
	},

	watch: {
		"type": function (value, oldValue) {
			if (value != "" && value != oldValue) {
				this.link = ""
				this.pageId = ""
			}
		}
	}
}