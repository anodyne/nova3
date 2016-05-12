Vue.component('icon-picker', {
	template: '#icon-picker-template',

	props: {
		selected: "",
		options: undefined
	},

	data: function () {
		return {
			config: {},
			icons: [{ key: "key", value: "value", preview: "preview" }],
			selectedIcon: ""
		}
	},

	methods: {
		setConfig: function () {
			var cfg = {
				inputClasses: "form-control input-lg",
				inputName: "icon"
			}

			if (this.options === undefined) {
				this.config = cfg
			} else {
				this.config = _.defaults(this.options, cfg)
			}
		}
	},

	ready: function () {
		this.setConfig()

		this.icons = Nova.data.icons
	}
})