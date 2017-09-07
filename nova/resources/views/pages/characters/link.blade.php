@extends('layouts.app')

@section('title', _m('characters-link'))

@section('content')
	<h1>{{ _m('characters-link') }}</h1>

	<div class="row">
		<div class="col-md-6 col-lg-4">
			<div class="form-group">
				<label class="form-control-label">{{ _m('users', [1]) }}</label>
				<div>
					<user-picker></user-picker>
				</div>
			</div>
		</div>
	</div>

	<div class="row" v-show="selectedUser">
		<div class="col-md-8 col-lg-5">
			<div class="form-group">
				<label class="form-control-label">{{ _m('users-assign-character') }}</label>
				<div>
					<character-picker filter="unassigned"></character-picker>
				</div>
			</div>
		</div>
	</div>

	<div class="row" v-show="selectedUser">
		<div class="col-md-9 col-lg-6">
			<fieldset>
				<legend>{{ _m('users-assigned-characters') }}</legend>

				<div class="data-table striped clean" v-if="usersCharacters.length > 0">
					<div class="row" v-for="character in usersCharacters">
						<div class="col">
							<avatar :item="character"></avatar>
						</div>
						<div class="col col-auto d-flex align-items-center">
							<a href="#"
							   class="text-subtle mr-2"
							   @click.prevent="setAsPrimaryCharacter(character)"
							   v-if="!character.isPrimaryCharacter">
								{!! icon('star') !!}
							</a>
							<a href="#"
							   class="text-danger"
							   @click.prevent="removeUserAssignment(character)">
								{!! icon('close-alt') !!}
							</a>
						</div>
					</div>
				</div>

				<div class="alert alert-warning" v-if="usersCharacters.length == 0">
					{{ _m('characters-error-not-found') }}
					{{ _m('characters-error-assign') }}
				</div>
			</fieldset>
		</div>
	</div>
@endsection

@section('js')
	<script>
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

						flash(_m('characters-flash-assigned-message'), _m('characters-flash-assigned-title'));
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

							flash(_m('characters-flash-unassigned-message'), _m('characters-flash-unassigned-title'));
						})
						.catch(function (error) {
							flash(
								_m('characters-flash-unassigned-error-message'),
								_m('characters-flash-unassigned-error-title'),
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

						flash(_m('characters-flash-primary-message'), _m('characters-flash-primary-title'));
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
					self.usersCharacters = user.characters;
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
	</script>
@endsection