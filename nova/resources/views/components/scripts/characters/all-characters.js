NovaVue = {
	data: {
		characters: Nova.data.characters,
		mobileFilter: false,
		mobileSearch: false,
		search: '',
		status: Nova.status.active
	},

	computed: {
		filteredCharacters () {
			let self = this
			let filteredCharacters = this.characters

			if (this.status != '') {
				filteredCharacters = filteredCharacters.filter(function (character) {
					return character.status == self.status
				})
			}

			return filteredCharacters.filter(function (character) {
				let regex = new RegExp(self.search, 'i')

				let search = regex.test(character.name)
					// || regex.test(character.position.name)
					// || regex.test(character.position.department.name)

				if (character.rank) {
					search = search || regex.test(character.rank.info.name)
				}

				if (character.user) {
					search = search
						|| regex.test(character.user.displayName)
						|| regex.test(character.user.email)
				}

				return search
			})
		},

		pendingCount () {
			return this.characters.filter(function (character) {
				return character.status == Nova.status.pending
			}).length
		}
	},

	methods: {
		activateCharacter (id) {
			let self = this;

			$.confirm({
				title: lang('characters-confirm-activate-title'),
				content: lang('characters-confirm-activate-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('activate'),
						btnClass: "btn-success",
						action () {
							axios.patch(route('characters.activate', { character:id }))
								 .then(function (response) {
								 	let index = _.findIndex(self.characters, function (c) {
										return c.id == id;
									});

									self.characters[index].status = Nova.status.active;

									flash(
										lang('characters-flash-activated-message'),
										lang('characters-flash-activated-title')
									);
								 });
						}
					},
					cancel: {
						text: lang('cancel')
					}
				}
			});
		},

		bioLink (id) {
			return route('characters.bio', { character:id });
		},

		deactivateCharacter (id) {
			let self = this;

			$.confirm({
				title: lang('characters-confirm-deactivate-title'),
				content: lang('characters-confirm-deactivate-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('deactivate'),
						btnClass: "btn-danger",
						action () {
							axios.delete(route('characters.deactivate', { character:id }))
								 .then(function (response) {
								 	let index = _.findIndex(self.characters, function (c) {
										return c.id == id;
									});

									self.characters[index].status = Nova.status.inactive;

									flash(
										lang('characters-flash-deactivated-message'),
										lang('characters-flash-deactivated-title')
									);
								 });
						}
					},
					cancel: {
						text: lang('cancel')
					}
				}
			});
		},

		deleteCharacter (id) {
			let self = this;

			$.confirm({
				title: lang('characters-confirm-delete-title'),
				content: lang('characters-confirm-delete-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('delete'),
						btnClass: "btn-danger",
						action () {
							axios.delete(route('characters.destroy', { character:id }))
								 .then(function (response) {
								 	let index = _.findIndex(self.characters, function (c) {
										return c.id == id;
									});

									self.characters[index].status = Nova.status.removed;

									flash(
										lang('characters-flash-deleted-message'),
										lang('characters-flash-deleted-title')
									);
								 });
						}
					},
					cancel: {
						text: lang('cancel')
					}
				}
			});
		},

		editLink (id) {
			return route('characters.edit', { character:id });
		},

		isActive (character) {
			return character.status == Nova.status.active;
		},

		isInactive (character) {
			return character.status == Nova.status.inactive;
		},

		isPending (character) {
			return character.status == Nova.status.pending;
		},

		isTrashed (character) {
			return character.status == Nova.status.removed;
		},

		resetSearch () {
			this.search = '';
			this.mobileSearch = false;
		},

		restoreCharacter (id) {
			let self = this;

			$.confirm({
				title: lang('characters-confirm-restore-title'),
				content: lang('characters-confirm-restore-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('restore'),
						btnClass: "btn-success",
						action () {
							axios.patch(route('characters.restore', { character:id }))
								 .then(function (response) {
								 	let index = _.findIndex(self.characters, function (c) {
										return c.id == id;
									});

								 	self.characters[index].deleted_at = null;
									self.characters[index].status = Nova.status.active;

									flash(
										lang('characters-flash-restored-message'),
										lang('characters-flash-restored-title')
									);
								 });
						}
					},
					cancel: {
						text: lang('cancel')
					}
				}
			});
		}
	}
}
