@extends('layouts.app')

@section('title', 'Manifest')

@section('content')
	<h1>Manifest</h1>

	<div class="row">
		<div class="col">
			<div class="row">
				<div class="col-md-9 col-lg-5">
					<div class="form-group input-group">
						<input type="text"
							   class="form-control"
							   placeholder="Find characters, departments, or positions"
							   v-model="search">
						<span class="input-group-btn">
							<a href="#" class="btn btn-secondary" @click.prevent="search = ''">{!! icon('close') !!}</a>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col col-auto">
			<a class="btn btn-secondary js-webuiPopover"
			   id="manifest-filters-trigger"
			   tabindex="0"
			   data-animation="pop"
			   data-placement="bottom-left"
			   data-offset-top="3"
			   data-width="275"
			   data-title="Filter Manifest"
			   data-url="#manifest-filters-content">{!! icon('filter') !!}</a>

			@can('update', $settingsClass)
				<a class="btn btn-secondary js-webuiPopover ml-1"
				   id="manifest-options-trigger"
				   tabindex="0"
				   data-animation="pop"
				   data-placement="bottom-left"
				   data-offset-top="3"
				   data-title="Manifest Options"
				   data-url="#manifest-options-content">{!! icon('settings-alt') !!}</a>
			@endcan
		</div>
	</div>

	<div v-show="layout == 'list'">
		<div class="row my-5" v-for="dept in filteredDepartments">
			<div class="col-lg-3">
				<p class="lead my-0">@{{ dept.name }}</p>
				{{-- <small class="text-muted d-block mb-3">
					We're looking for a creative pilot to fill the Chief Flight Control Officer position and point us in the right direction as we boldly go where no one has gone before!
				</small> --}}
			</div>

			<div class="col">
				<div v-for="position in dept.positions">
					<div class="row d-flex align-items-center mb-4"
						 v-for="character in filterCharacters(position.characters)"
						 v-if="position.characters.length > 0">
						<div class="col col-auto">
							<rank :item="character.rank"></rank>
						</div>
						<div class="col">
							<avatar :item="character">
								@{{ position.name }}
							</avatar>
						</div>
						<div class="col col-auto">
							<a href="#" class="btn btn-lg btn-link text-muted">{!! icon('user-alt') !!}</a>
						</div>
					</div>

					<div class="row d-flex align-items-center mb-4" v-if="position.available > 0 && showAvailable">
						<div class="col col-auto">
							<rank></rank>
						</div>
						<div class="col">
							<position-available :position="position" :show-image="false"></position-available>
						</div>
					</div>
				</div>
			</div>
		</div>
		{{-- <fieldset v-for="dept in filteredDepartments">
			<legend>@{{ dept.name }}</legend>

			<div class="data-table clean striped">
				<div class="row align-items-center" v-for="position in dept.positions">
					<div v-show="position.characters.length == 0">
						<div class="col col-auto">
							<rank></rank>
						</div>
						<div class="col">
							<p class="mb-0"><strong v-text="position.name"></strong></p>
							<small><a href="#">Position Open &ndash; Apply Now</a></small>
						</div>
					</div>
				</div>
			</div>

			<div class="data-table clean striped">
				<div class="row align-items-center"
					 v-for="position in dept.positions"
					 v-show="position.characters.length > 0">
					<div class="col">
						<div class="row align-items-center" v-for="character in position.characters">
							<div class="col col-auto">
								<rank :item="character.rank"></rank>
							</div>
							<div class="col">
								<avatar :item="character"></avatar>
							</div>
							<div class="col col-auto">
								<a href="#"><img src="{{ asset('assets/images/starfleet-vector-logo.svg') }}"></a>
							</div>
						</div>
						<div class="row align-items-center" v-if="position.available > 0 && showAvailable">
							<div class="col col-auto">
								<rank></rank>
							</div>
							<div class="col">
								<p class="mb-0"><strong v-text="position.name"></strong></p>
								<small><a href="#">Position Open &ndash; Apply Now</a></small>
							</div>
						</div>
					</div>
					<div class="col" v-show="position.characters.length == 0 && showAvailable">
						<div class="row align-items-center">
							<div class="col col-auto">
								<rank></rank>
							</div>
							<div class="col">
								<p class="mb-0"><strong v-text="position.name"></strong></p>
								<small><a href="#">Position Open &ndash; Apply Now</a></small>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div v-if="dept.sub_departments.length > 0">
				<fieldset class="ml-3" v-for="subDept in dept.sub_departments">
					<legend>@{{ subDept.name }}</legend>

					<div class="data-table clean striped">
						<div class="row align-items-center"
							 v-for="subPosition in subDept.positions">
							<div class="col" v-show="subPosition.characters.length > 0">
								<div class="row align-items-center" v-for="character in subPosition.characters">
									<div class="col col-auto">
										<rank :item="character.rank"></rank>
									</div>
									<div class="col">
										<avatar :item="character"></avatar>
									</div>
									<div class="col col-auto">
										<a href="#"><img src="{{ asset('assets/images/starfleet-vector-logo.svg') }}"></a>
									</div>
								</div>
							</div>
							<div class="col" v-show="subPosition.characters.length == 0 && showAvailable">
								<div class="row align-items-center">
									<div class="col col-auto">
										<rank></rank>
									</div>
									<div class="col">
										<p class="mb-0"><strong v-text="subPosition.name"></strong></p>
										<small><a href="#">Position Open &ndash; Apply Now</a></small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</div>
		</fieldset> --}}
	</div>

	<div v-show="layout == 'cards'"></div>

	<div class="d-none">
		<div id="manifest-filters-content">
			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" v-model="showCharacters">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Characters</span>
				</label>
			</div>

			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" v-model="showNPCs">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">NPCs</span>
				</label>
			</div>

			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" v-model="showInactive">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Inactive characters</span>
				</label>
			</div>

			<label class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" v-model="showAvailable">
				<span class="custom-control-indicator"></span>
				<span class="custom-control-description">Available positions</span>
			</label>
		</div>

		@can('update', $settingsClass)
			<div id="manifest-options-content">
				<div class="form-group">
					<label class="custom-control custom-radio d-flex align-items-center">
						<input name="layout" type="radio" value="list" class="custom-control-input" v-model="layout">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description d-flex align-items-center">
							<i class="far fa-list fa-lg fa-fw mr-2 text-muted"></i>
							<span>List</span>
						</span>
					</label>
				</div>

				<div class="form-group">
					<label class="custom-control custom-radio d-flex align-items-center">
						<input name="layout" type="radio" value="card" class="custom-control-input" v-model="layout">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description d-flex align-items-center">
							{!! icon('card', 'fa-lg fa-fw mr-2 text-muted') !!}
							<span>Cards</span>
						</span>
					</label>
				</div>

				<p class="text-info mb-0"><strong>Note:</strong> Manifest layout changes will apply to all visitors.</p>
			</div>
		@endcan
	</div>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				departments: {!! $departments !!},
				layout: 'list',
				search: '',
				showAvailable: {{ $settings['manifest_show_available'] }},
				showInactive: {{ $settings['manifest_show_inactive'] }},
				showNPCs: {{ $settings['manifest_show_npcs'] }},
				showCharacters: {{ $settings['manifest_show_assigned'] }}
			},

			computed: {
				filteredDepartments () {
					return filter(this.departments, this.search)
				}
			},

			methods: {
				filterCharacters (characters) {
					let self = this;

					let charactersToShow = characters.filter(function (c) {
						if (self.showInactive) {
							return c.status == {{ Status::ACTIVE }}
								|| c.status == {{ Status::INACTIVE }};
						}

						return c.status == {{ Status::ACTIVE }};
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
				}
			},

			watch: {
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
	</script>
@endsection