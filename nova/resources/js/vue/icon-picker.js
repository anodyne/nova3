Vue.component('icon-picker', {
	template: '#icon-picker-template',

	props: {
		selected: ""
	},

	data: function () {
		return {
			config: {},
			iconPreview: "",
			icons: [{ key: "key", value: "value", preview: "preview" }],
			selectedIcon: ""
		}
	},

	ready: function () {
		this.icons = Nova.data.icons
		this.selectedIcon = this.selected
	},

	watch: {
		"selectedIcon": function (newValue, oldValue) {
			if (newValue == "") {
				this.iconPreview = ""
			} else {
				var icon

				for (var i = 0; i < this.icons.length; i++) {
					var loopIcon = this.icons[i]

					if (loopIcon.key == newValue) {
						this.iconPreview = loopIcon.preview
					}
				}
			}
		}
	}
})