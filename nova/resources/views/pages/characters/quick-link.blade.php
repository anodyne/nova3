@extends('layouts.app')

@section('title', 'Quick Link')

@section('content')
	<h1>Quick Link</h1>

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
					axios.post(route('characters.link.store'), {
						user: this.selectedUser.id,
						character: this.selectedCharacter.id
					}).then(function (response) {
						console.log(response);
						self.usersCharacters = response.data;

						flash('Character succesfully assigned.', 'Character assigned.');
					});
				},

				removeUserAssignment (character) {
					axios.delete(route('characters.link.destroy'), {
						user: this.selectedUser.id,
						character: character.id
					})
					
					let index = _.findIndex(this.usersCharacters, function (c) {
						return c.id == character.id;
					});

					this.usersCharacters.splice(index, 1);
				}
			},

			mounted () {
				let self = this;

				window.events.$on('user-picker-selected', function (user) {
					self.selectedUser = user;
					self.usersCharacters = user.characters;
				});

				window.events.$on('character-picker-selected', function (character) {
					self.selectedCharacter = character;
					//self.usersCharacters.push(character);

					window.events.$emit('character-picker-reset');

					// Now assign the character to the user
					self.assignCharacter();
				});
			}
		}
	</script>
@endsection