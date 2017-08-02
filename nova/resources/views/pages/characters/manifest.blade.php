@extends('layouts.app')

@section('title', 'Manifest')

@section('content')
	<h1>Manifest</h1>

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
				departments: {!! $departments !!}
			},

			computed: {
				filteredDepartments () {
					let self = this

					return this.departments

					return this.departments.filter(function (dept) {
						let regex = new RegExp(self.search, 'i')
					})
				}
			}
		}
	</script>
@endsection