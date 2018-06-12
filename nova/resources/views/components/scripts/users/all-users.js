NovaVue = {
	data: {
		users: Nova.data.users,
		mobileFilter: false,
		mobileSearch: false,
		search: '',
		showCharacters: false,
		status: Nova.status.active
	},

	computed: {
		filteredUsers () {
			let self = this;
			let filteredUsers = this.users;

			if (this.status != '') {
				filteredUsers = filteredUsers.filter(function (user) {
					return user.status == self.status;
				});
			}

			return filter(filteredUsers, this.search);
		},

		pendingCount () {
			return this.users.filter(function (user) {
				return user.status == Nova.status.pending;
			}).length;
		}
	},

	methods: {
		activateUser (id) {
			let self = this;

			$.confirm({
				title: lang('users-confirm-activate-title'),
				content: lang('users-confirm-activate-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('activate'),
						btnClass: "btn-success",
						action () {
							axios.patch(route('users.activate', { user:id }))
								 .then(function (response) {
								 	let index = _.findIndex(self.users, function (u) {
										return u.id == id;
									});

									self.users[index].status = Nova.status.active;

									flash(lang('users-flash-activated-message'), lang('users-flash-activated-title'));
								 });
						}
					},
					cancel: {
						text: lang('cancel')
					}
				}
			});
		},

		deactivateUser (id) {
			let self = this;

			$.confirm({
				title: lang('users-confirm-deactivate-title'),
				content: lang('users-confirm-deactivate-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('deactivate'),
						btnClass: "btn-danger",
						action () {
							axios.delete(route('users.deactivate', { user:id }))
								 .then(function (response) {
								 	let index = _.findIndex(self.users, function (u) {
										return u.id == id;
									});

									self.users[index].status = Nova.status.inactive;

									flash(
										lang('users-flash-deactivated-message'),
										lang('users-flash-deactivated-title')
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

		deleteUser (id) {
			let self = this;

			$.confirm({
				title: lang('users-confirm-delete-title'),
				content: lang('users-confirm-delete-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('delete'),
						btnClass: "btn-danger",
						action () {
							axios.delete(route('users.destroy', { user:id }))
								 .then(function (response) {
								 	let index = _.findIndex(self.users, function (u) {
										return u.id == id;
									});

									self.users[index].status = Nova.status.removed;
									self.users[index].deleted_at = moment().format('YYYY-MM-DD HH:mm:ss');

									flash(lang('users-flash-deleted-message'), lang('users-flash-deleted-title'));
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
			return route('users.edit', { user:id });
		},

		isActive (user) {
			return user.status == Nova.status.active;
		},

		isInactive (user) {
			return user.status == Nova.status.inactive;
		},

		isPending (user) {
			return user.status == Nova.status.pending;
		},

		isTrashed (user) {
			return user.status == Nova.status.removed;
		},

		profileLink (id) {
			return route('profile.show', { user:id });
		},

		resetSearch () {
			this.search = '';
		},

		restoreUser (id) {
			let self = this;

			$.confirm({
				title: lang('users-confirm-restore-title'),
				content: lang('users-confirm-restore-message'),
				columnClass: "medium",
				theme: "dark",
				buttons: {
					confirm: {
						text: lang('restore'),
						btnClass: "btn-success",
						action () {
							axios.patch(route('users.restore', { user:id }))
								 .then(function (response) {
								 	let index = _.findIndex(self.users, function (u) {
										return u.id == id;
									});

									self.users[index].status = Nova.status.active;
									self.users[index].deleted_at = null;

									flash(lang('users-flash-restored-message'), lang('users-flash-restored-title'));
								 });
						}
					},
					cancel: {
						text: lang('cancel')
					}
				}
			});
		},

		usersCharacters (user) {
			let characters = [];

			_.forEach(user.characters, function (character) {
				characters.push(character.name);
			});

			return characters.join(', ');
		}
	},

	watch: {
		search (newValue, oldValue) {
			this.mobileSearch = false;
			this.showCharacters = false;
		}
	}
}

function filter (data, term) {
	let matches = [];
	let regex = new RegExp(term, 'i');

	if (! Array.isArray(data)) {
		return matches;
	}

	data.forEach(function (d) {
		if (regex.test(d.name) || regex.test(d.email)) {
			matches.push(d);
		} else {
			let charactersResults = filter(d.characters, term);
			if (charactersResults.length > 0) {
				matches.push(Object.assign({}, d, { characters: charactersResults }));

				vue.data.showCharacters = true;
			}
		}
	});

	return matches;
}
