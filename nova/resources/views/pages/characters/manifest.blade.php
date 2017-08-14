@extends('layouts.app')

@section('title', 'Manifest')

@section('content')
	<h1>Manifest</h1>

	<input type="search" v-model="search">

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

		{{-- @if ($department->subDepartments->count() > 0)
			@foreach ($department->subDepartments as $subDepartment)
				<fieldset class="ml-3">
					<legend>{{ $subDepartment->name }}</legend>

					<div class="data-table">
						@foreach ($subDepartment->positions as $subPosition)
							<div class="row">
								<div class="col">
									<p class="mb-0">{{ $subPosition->name }}</p>
								</div>
							</div>
						@endforeach
					</div>
				</fieldset>
			@endforeach
		@endif --}}
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
					let self = this

					const flattenItems = (items, key) => {
						return items.reduce((flattenedItems, item) => {
							flattenedItems.push(item)

							if (Array.isArray(item[key])) {
								flattenedItems = flattenedItems.concat(flattenItems(item[key], key))
							}

							return flattenedItems
						}, [])
					}
					let items = pickDeep(this.departments, 'name', ['name'])
					let filtered = items.filter(function (item) {
						let regex = new RegExp(self.search, 'i')

						return regex.test(item.name)
					})
					console.log(filtered)

					return this.departments

					return this.departments.filter(function (dept) {
						let regex = new RegExp(self.search, 'i')

						return regex.test(dept.name) ||
							   regex.test(dept.positions.name) ||
							   regex.test(dept.positions.characters.displayName) ||
							   regex.test(dept.sub_departments.name) ||
							   regex.test(dept.sub_departments.positions.name) ||
							   regex.test(dept.sub_departments.positions.characters.displayName)
					})

					// department.name
					// department.positions.name
					// department.positions.characters.name
					// department.sub_departments.name
					// department.sub_departments.positions.name
					// department.sub_departments.positions.characters.name
				}
			}
		}

		function pickDeep(collection, predicate, thisArg) {
			if (_.isFunction(predicate)) {
				predicate = _.iteratee(predicate, thisArg);
			} else {
				var keys = _.flatten(_.tail(arguments));
				predicate = function(val, key) {
					return _.includes(keys, key);
				}
			}

			return _.transform(collection, function(memo, val, key) {
				var include = predicate(val, key);
				if (!include && _.isObject(val)) {
					val = pickDeep(val, predicate);
					include = !_.isEmpty(val);
				}
				if (include) {
					_.isArray(collection) ? memo.push(val) : memo[key] = val;
				}
			});
		}
	</script>
@endsection