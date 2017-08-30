@extends('layouts.app')

@section('title', 'Manifest')

@section('content')
	<h1>Manifest</h1>

	<div>
		<small>Character, tiny, stacked, with status</small>
		<avatar :item="{{ $character1 }}" layout="stacked" size="xs" :show-status="true"></avatar>
	</div>

	<div>
		<small>Character, tiny, spread, with status</small>
		<avatar :item="{{ $character1 }}" layout="spread" size="xs" :show-status="true"></avatar>
	</div>

	<div>
		<small>Character, tiny, image only</small>
		<avatar :item="{{ $character1 }}" size="xs" :show-status="false" :show-content="false"></avatar>
	</div>

	<div>
		<small>Character, tiny, spread, with other metadata</small>
		<avatar :item="{{ $character1 }}" layout="spread" size="xs" :show-status="false">
			Some other metadata
		</avatar>
	</div>

	<div>
		<small>User, tiny, image only</small>
		<avatar :item="{{ $user }}" size="xs" :show-status="false" :show-content="false"></avatar>
	</div>

	<div>
		<small>User, tiny, no metadata</small>
		<avatar :item="{{ $user }}" size="xs" :show-status="false" :show-metadata="false"></avatar>
	</div>

	<div>
		<small>User, tiny, w/ metadata</small>
		<avatar :item="{{ $user }}" size="xs" :show-status="false">
			1,000 XP &bull; Joined 2 years ago
		</avatar>
	</div>

	<h2>Tiny</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="stacked"
						size="xs"
						:show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="spread"
						size="xs"
						:show-status="true"></avatar>
			</div>
		</div>
	</div>

	<h2>Small</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
								  layout="stacked"
								  size="sm"
								  :show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
								  layout="spread"
								  size="sm"
								  :show-status="true"></avatar>
			</div>
		</div>
	</div>

	<h2>Normal</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
								  layout="stacked"
								  :show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
								  layout="spread"
								  :show-status="true"></avatar>
			</div>
		</div>
	</div>

	<h2>Medium</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
								  layout="stacked"
								  size="md"
								  :show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
								  layout="spread"
								  size="md"
								  :show-status="true"></avatar>
			</div>
		</div>
	</div>

	<h2>Large</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
								  layout="stacked"
								  size="lg"
								  :show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
								  layout="spread"
								  size="lg"
								  :show-status="true"></avatar>
			</div>
		</div>
	</div>

	<h2>Jumbo</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
								  layout="stacked"
								  size="xl"
								  :show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
								  layout="spread"
								  size="xl"
								  :show-status="true"></avatar>
			</div>
		</div>
	</div>

	<div class="row mt-4">
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
			<a class="btn btn-secondary btn-action js-popover"
			   id="manifest-filters-trigger"
			   tabindex="0"
			   data-placement="bottom"
			   title="Filter Manifest">{!! icon('filter') !!}</a>
			<a class="btn btn-secondary btn-action js-popover ml-1"
			   id="manifest-options-trigger"
			   tabindex="0"
			   data-placement="bottom"
			   title="Manifest Options">{!! icon('settings-alt') !!}</a>
		</div>
	</div>

	<div v-show="layout == 'list'">
		<fieldset v-for="dept in filteredDepartments">
			<legend>@{{ dept.name }}</legend>

			<div class="data-table clean striped">
				<div class="row align-items-center"
					 v-for="position in dept.positions">
					<div class="col" v-show="position.characters.length > 0">
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
		</fieldset>
	</div>

	<div v-show="layout == 'cards'">
		<fieldset v-for="dept in filteredDepartments">
			<legend>@{{ dept.name }}</legend>

			<div class="row">
				<div class="col-md-6 col-lg-4">
					<a href="#" class="card">
						<div class="card-body">
							<div class="d-flex align-items-center justify-content-around flex-column">
								<div class="mb-2">
									<position-available :position="{{ $position }}"></position-available>
								</div>
								<rank></rank>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-6 col-lg-4">
					<a href="#" class="card">
						<div class="card-body">
							<div class="d-flex align-items-center justify-content-around flex-column">
								<div class="mb-2">
									<avatar :item="{{ $character1 }}"
													  :show-status="true"
													  size="md"
													  layout="stacked">
									</avatar>
								</div>
								<rank :item="{{ $character1->rank }}"></rank>
							</div>
						</div>
					</a>
				</div>
			</div>
		</fieldset>
	</div>

	<div class="d-none">
		<div id="manifest-filters-content">
			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">Primary characters</span>
				</label>
			</div>

			<div class="form-group">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">NPCs</span>
				</label>
			</div>

			<label class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" v-model="showAvailable">
				<span class="custom-control-indicator"></span>
				<span class="custom-control-description">Available positions</span>
			</label>

		</div>

		<div id="manifest-options-content">
			<div class="form-group">
				<label class="custom-control custom-radio d-flex align-items-center">
					<input name="layout" type="radio" value="list" class="custom-control-input" v-model="layout">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description d-flex align-items-center">
						<i class="far fa-list fa-lg mr-2 text-muted"></i>
						<span>List</span>
					</span>
				</label>
			</div>

			<div class="form-group">
				<label class="custom-control custom-radio d-flex align-items-center">
					<input name="layout" type="radio" value="card" class="custom-control-input" v-model="layout">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description d-flex align-items-center">
						{!! icon('card', 'fa-lg mr-2 text-muted') !!}
						<span>Cards</span>
					</span>
				</label>
			</div>

			<p class="text-info mb-0"><strong>Note:</strong> Manifest layout changes will apply to all visitors.</p>
		</div>
	</div>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				departments: {!! $departments !!},
				layout: 'cards',
				search: '',
				showAvailable: true
			},

			computed: {
				filteredDepartments () {
					return filter(this.departments, this.search)
				}
			},

			mounted () {
				$('#manifest-filters-trigger').on('click', function (e) {
					e.preventDefault()
					$('#manifest-options-trigger').popover('hide')
				}).popover({
					container: 'body',
					content: $('#manifest-filters-content'),
					html: true,
					trigger: 'focus'
				})

				$('#manifest-options-trigger').on('click', function (e) {
					e.preventDefault()
					$('#manifest-filters-trigger').popover('hide')
				}).popover({
					container: 'body',
					content: $('#manifest-options-content'),
					html: true,
					trigger: 'focus'
				})

				$('body').on('click', function (e) {
					console.log(e.target.parentElement)
				})
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