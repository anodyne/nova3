NovaVue = {
	data: {
		section: 'clients'
	},

	methods: {
		navItemClass (section) {
			let pieces = ['flex', 'text-xs', 'no-underline', 'p-2', 'border-b-2', 'border-transparent', 'hover:text-grey-darker']

			if (section == this.section) {
				pieces.push('text-grey-darkest')
				pieces.push('border-primary')
				pieces.push('font-medium')
			} else {
				pieces.push('text-grey-dark')
			}

			return pieces
		},

		switchSection (section) {
			this.section = section
		}
	}
}
