@extends('layouts.setup')

@section('title', 'Verify Character Data')

@section('header', 'Verify Character Data')

@section('content')
	<h1>Verify Character Data</h1>
	<h3>Let's make sure all of your character data is right.</h3>

	<p>Here you can verify that the ranks for your characters have migrated properly. After you've made changes to a character's rank or verified that it is correct, you can click on the checkmark to hide that row and make it easier to work through the list. When you're finished, click on the <strong>Update Characters</strong> button at the bottom of the page to run the update and finish the process.</p>

	<p>If you do not want to do the character verification now, you can click the <strong>Skip</strong> button at the bottom of the page to move on to the final step of the migration. You can use the Characters Management page to see all of your characters and do the verification within Nova.</p>

	<div class="row" v-cloak>
		<div class="col-lg-10 col-xl-9 mx-auto">
			<div class="data-table bordered striped">
				<div class="row align-items-center" v-for="character in characters" v-if="!character.finished">
					<div class="col-md-6 d-flex align-items-center">
						<a href="#"
						   class="text-muted mr-2"
						   @click.prevent="character.finished = true">
						   <i class="fa fa-check"></i>
						</a>
						<avatar :item="character" type="nothing" :show-status="false"></avatar>
					</div>
					<div class="col-md-6">
						<rank-picker :selected="character.rank"
									 :initial-ranks="{{ $ranks }}"
									 :character="character">
						</rank-picker>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row" v-cloak>
		<div class="col-md-4 col-lg-3 offset-md-2 offset-lg-3">
			<p>
				<a role="button"
				   href="#"
				   :class="updateButton"
				   @click.prevent="updateAllCharacters()">
					<span v-show="!active">Update Characters</span>
					<span v-show="active">
						<i class="fa fa-spinner-third fa-spin fa-lg fa-fw"></i>
					</span>
				</a>
			</p>
		</div>
		<div class="col-md-4 col-lg-3">
			<p><a href="{{ route('setup.'.$_setupType.'.settings') }}" class="btn btn-outline-secondary btn-block">Skip</a></p>
		</div>
	</div>
@endsection

@section('controls')
	<a href="{{ route('setup.'.$_setupType.'.settings') }}" :class="nextButton">
		Next: Update {{ config('nova.app.name') }} Settings
	</a>
	<a href="{{ route('setup.'.$_setupType.'.nova') }}" class="btn btn-link-secondary btn-lg">
		Back: Migrate Nova 2
	</a>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				active: false,
				characters: {!! $characters !!},
				complete: false,
				updateData: []
			},

			computed: {
				nextButton () {
					if (this.complete) {
						return ['btn', 'btn-primary', 'btn-lg'];
					}

					return ['btn', 'btn-primary', 'btn-lg', 'disabled'];
				},

				updateButton () {
					if (this.active) {
						return ['btn', 'btn-outline-primary', 'btn-block', 'disabled'];
					}

					return ['btn', 'btn-outline-primary', 'btn-block'];
				}
			},

			methods: {
				updateCharacter (id, rank) {
					// Check to see if we've already got a record for this
					// character before we create a new one
					let index = _.findIndex(this.updateData, function (u) {
						return u.id == id;
					});

					// If we do have a record, update what's there, otherwise
					// create a new record in the array
					if (index >= 0) {
						this.updateData[index].rank = rank;
					} else {
						this.updateData.push({ id: id, rank: rank});
					}
				},

				updateAllCharacters () {
					let self = this;

					this.active = true;

					axios.post(route('setup.migrate.characters.update'), {
						characters: this.updateData
					})
						.then(function (response) {
							self.active = false;
							self.complete = true;
						})
						.catch(function (error) {
							self.active = false;
							self.complete = true;
						});
				}
			},

			mounted () {
				let self = this;

				window.events.$on('rank-picker-selected', (rank, character) => {
					self.updateCharacter(character.id, rank.id);
				});
			}
		};
	</script>
@endsection