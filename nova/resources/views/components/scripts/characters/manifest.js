NovaVue = {
	data: {
		departments: Nova.data.departments,
		layout: Nova.settings.manifest_layout,
		search: '',
		showAvailable: Nova.settings.manifest_show_available,
		showInactive: Nova.settings.manifest_show_inactive,
		showNPCs: Nova.settings.manifest_show_npcs,
		showCharacters: Nova.settings.manifest_show_assigned
	},

	computed: {
		filteredDepartments () {
			return filter(this.departments, this.search)
		}
	},

	methods: {
		bioLink (id) {
			return route('characters.bio', {character:id});
		},

		filterCharacters (characters) {
			let self = this;

			let charactersToShow = characters.filter(function (c) {
				if (self.showInactive) {
					return c.status == Nova.status.active
						|| c.status == Nova.status.inactive;
				}

				return c.status == Nova.status.active;
			});

			if (! this.showNPCs) {
				charactersToShow = charactersToShow.filter(function (c) {
					return c.user_id !== null;
				});
			}

			if (! this.showCharacters) {
				charactersToShow = charactersToShow.filter(function (c) {
					return c.user_id === null;
				});
			}

			return charactersToShow;
		},

		shouldShow (position) {
			// console.log(document.querySelectorAll('[data-position="' + position + '"]'));
			return $('[data-position="' + position + '"]').html() != '';
		}
	},

	watch: {
		layout (newValue, oldValue) {
			let data = {
				'manifest_layout': newValue
			};

			axios.patch(route('settings.update'), data)
				 .then(function (response) {
				 	flash('Manifest layout option has been updated.', 'Settings updated');
				 })
				 .catch(function (error) {
				 	//
				 });
		},

		showCharacters (newValue, oldValue) {
			if (newValue == false) {
				this.showInactive = false;
			}
		}
	},

	mounted () {
		$('.js-webuiPopover').webuiPopover();
	}
}

function filter (data, term) {
	let matches = []
	let regex = new RegExp(term, 'i')

	if (! Array.isArray(data)) {
		return matches
	}

	data.forEach(function (d) {
		if (regex.test(d.name)) {
			matches.push(d)
		} else {
			let positionsResults = filter(d.positions, term)
			if (positionsResults.length > 0) {
				matches.push(Object.assign({}, d, { positions: positionsResults }))
			}

			let subDepartmentsResults = filter(d.sub_departments, term)
			if (subDepartmentsResults.length > 0) {
				matches.push(Object.assign({}, d, { sub_departments: subDepartmentsResults }))
			}

			let charactersResults = filter(d.characters, term)
			if (charactersResults.length > 0) {
				matches.push(Object.assign({}, d, { characters: charactersResults }))
			}
		}
	})

	return matches
}
