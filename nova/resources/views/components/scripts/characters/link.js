vue = {
	data: {
		selectedCharacter: '',
		selectedUser: '',
		usersCharacters: ''
	},

	methods: {
		assignCharacter () {
			let self = this;

			axios.post(route('characters.link.store'), {
				user: this.selectedUser.id,
				character: this.selectedCharacter.id
			}).then(function (response) {
				// Refresh the character picker to make sure we have
				// an accurate list of unassigned characters
				window.events.$emit('character-picker-refresh');

				// Update the list of assigned characters
				self.usersCharacters = response.data;

				flash(lang('characters-flash-assigned-message'), lang('characters-flash-assigned-title'));
			});
		},

		removeUserAssignment (character) {
			let self = this;

			axios.delete(route('characters.link.destroy', { character: character.id }))
				.then(function (response) {
					// Refresh the character picker to make sure we have
					// an accurate list of unassigned characters
					window.events.$emit('character-picker-refresh');

					// Find the index of the character we just unassigned
					let index = _.findIndex(self.usersCharacters, function (c) {
						return c.id == character.id;
					});

					// Now remove that character from the list
					self.usersCharacters.splice(index, 1);

					flash(lang('characters-flash-unassigned-message'), lang('characters-flash-unassigned-title'));
				})
				.catch(function (error) {
					flash(
						lang('characters-flash-unassigned-error-message'),
						lang('characters-flash-unassigned-error-title'),
						'danger'
					);
				});
		},

		setAsPrimaryCharacter (character) {
			let self = this;

			axios.patch(route('characters.link.update'), {
				character: character.id
			}).then(function (response) {
				console.log(response.data);
				// Update the list of assigned characters
				self.usersCharacters = response.data;

				flash(lang('characters-flash-primary-message'), lang('characters-flash-primary-title'));
			}).catch(function (error) {
				//
			});
		}
	},

	created () {
		let self = this;

		window.events.$on('user-picker-selected', function (user) {
			// Set the selected user
			self.selectedUser = user;

			// Grab the user's characters
			self.usersCharacters = user.all_characters;
		});

		window.events.$on('character-picker-selected', function (character) {
			// Set the selected character
			self.selectedCharacter = character;

			// Reset the character picker to a clean state
			window.events.$emit('character-picker-reset');

			// Now assign the character to the user
			self.assignCharacter();
		});
	}
}
