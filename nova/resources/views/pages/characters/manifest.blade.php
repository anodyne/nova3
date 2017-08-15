@extends('layouts.app')

@section('title', 'Manifest')

@section('content')
	<h1>Manifest</h1>

	<div class="row">
		<div class="col-md-5">
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

	<fieldset v-for="dept in filteredDepartments">
		<legend>@{{ dept.name }}</legend>

		<div class="data-table">
			<div class="row align-items-center"
				 v-for="position in dept.positions">
				<div class="col" v-show="position.characters.length > 0">
					<div class="row align-items-center" v-for="character in position.characters">
						<div class="col col-auto">
							<rank :item="character.rank"></rank>
						</div>
						<div class="col">
							<character-avatar :character="character"></character-avatar>
						</div>
					</div>
				</div>
				<div class="col" v-show="position.characters.length == 0">
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

				<div class="data-table">
					<div class="row align-items-center"
						 v-for="subPosition in subDept.positions">
						<div class="col" v-show="subPosition.characters.length > 0">
							<div class="row align-items-center" v-for="character in subPosition.characters">
								<div class="col col-auto">
									<rank :item="character.rank"></rank>
								</div>
								<div class="col">
									<character-avatar :character="character"></character-avatar>
								</div>
							</div>
						</div>
						<div class="col" v-show="subPosition.characters.length == 0">
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
@endsection

@section('js')
	<script>
		vue = {
			data: {
				departments: {!! $departments !!},
				search: ''
			},

			computed: {
				filteredDepartments () {
					return filter(this.departments, this.search)
				}
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