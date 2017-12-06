vue = {
	data: {
		active: 'manifest',
		manifestLayout: window.Nova.settings.manifest_layout,
		manifestShowAssigned: window.Nova.settings.manifest_show_assigned,
		manifestShowAvailable: window.Nova.settings.manifest_show_available,
		manifestShowInactive: window.Nova.settings.manifest_show_inactive,
		manifestShowNPCs: window.Nova.settings.manifest_show_npcs
	},

	methods: {
		navClasses (section) {
			let pieces = [
				'list-group-item',
				'list-group-item-action'
			];

			if (section == this.active) {
				pieces.push('active');
			}

			return pieces;
		},

		saveSettings () {
			let data = {
				'manifest_layout': this.manifestLayout,
				'manifest_show_assigned': this.manifestShowAssigned,
				'manifest_show_inactive': this.manifestShowInactive,
				'manifest_show_npcs': this.manifestShowNPCs,
				'manifest_show_available': this.manifestShowAvailable,
			};

			axios.patch(route('settings.update'), data)
				 .then(function (response) {
				 	flash('Site settings have been updated.', 'Settings updated');
				 })
				 .catch(function (error) {
				 	//
				 });
		},

		toggleSwitch (field) {
			this[field] = !this[field];
		}
	}
};
