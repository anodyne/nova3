NovaVue = {
	data: {
		accordion: 'info',
		base: Nova.data.item.base,
		overlay: Nova.data.item.overlay
	},

	computed: {
		baseStyles () {
			return 'background-image:url(/ranks/' + Nova.settings.rank + '/base/' + this.base + ')'
		},

		overlayStyles () {
			return 'background-image:url(/ranks/' + Nova.settings.rank + '/overlay/' + this.overlay + ')'
		}
	},

	methods: {
		baseSelector (image) {
			return ['rank-selector', (image == this.base) ? 'selected' : '']
		},

		changeImage (type, image) {
			if (type == 'base') {
				this.base = image
			}

			if (type == 'overlay') {
				this.overlay = image
			}
		},

		overlaySelector (image) {
			return ['rank-selector', (image == this.overlay) ? 'selected' : '']
		}
	}
}
