@extends('layouts.app')

@section('title', _m('genre-positions'))

@section('content')
	<h1>{{ _m('genre-positions') }}</h1>

	@if ($positions->count() > 0)
		<div class="data-table bordered striped" id="sortable">
			<div class="row header">
				<div class="col-8 col-md-5">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('genre-positions-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="search = ''">{!! icon('close') !!}</a>
						</span>
					</div>
					<div class="mt-2 hidden-md-up">
						{!! Form::departments(null, $departments, null, ['v-model' => 'department', 'placeholder' => _m('genre-dept-select')]) !!}
					</div>
				</div>
				<div class="col hidden-sm-down">
					{!! Form::departments(null, $departments, null, ['v-model' => 'department', 'placeholder' => _m('genre-dept-select')]) !!}
				</div>
				<div class="col col-xs-auto">
					<div class="btn-toolbar pull-right">
						@can('create', $positionClass)
							<a href="{{ route('positions.create') }}" class="btn btn-success">{!! icon('add') !!}</a>
						@endcan

						@can('update', $positionClass)
							<a href="#"
							   class="btn btn-primary ml-2"
							   v-if="department != ''"
							   @click.prevent="updatePositions">{!! icon('submit') !!}</a>
						@endcan
					</div>
				</div>
			</div>
			<div class="row" v-if="department == ''">
				<div class="col">
					<div class="alert alert-info mb-0">
						{{ _m('genre-positions-start') }}
					</div>
				</div>
			</div>
			<div class="row" v-if="department != '' && filteredPositions.length == 0">
				<div class="col">
					<div class="alert alert-warning mb-0">
						{{ _m('genre-positions-error-not-found-dept') }}
					</div>
				</div>
			</div>
			<div class="row align-items-start"
				 :data-id="position.id"
				 v-if="department != '' && filteredPositions.length > 0"
				 v-for="position in filteredPositions">
				<div class="col col-auto">
					<span class="sortable-handle text-subtle">{!! icon('reorder') !!}</span>
				</div>
				<div class="col-9">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">{{ _m('name') }}</label>
								<input type="text" class="form-control" v-model=position.name>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">{{ _m('genre-dept') }}</label>
								<div>
									{!! Form::departments(null, $departments, null, ['v-model' => 'position.department_id']) !!}
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">{{ _m('description') }}</label>
								<textarea class="form-control" rows="5" v-model=position.description></textarea>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-control-label">{{ _m('genre-positions-available') }}</label>
								<input type="number" class="form-control" v-model=position.available>
							</div>

							<div class="form-group">
								<label class="form-control-label">{{ _m('displayed') }}</label>
								<div>
									<toggle-button class="toggle-switch"
												   :value="position.display == 1"
												   :data-position="position.id"
												   @change="toggleDisplay"></toggle-button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col col-xs-auto">
					@can('delete', $positionClass)
						<a href="#"
						   class="btn btn-outline-danger btn-action pull-right"
						   :data-position="position.id"
						   @click.prevent="deletePosition">{!! icon('delete') !!}</a>
					@endcan
				</div>
			</div>
		</div>
	@else
		<div class="alert alert-warning">
			{{ _m('genre-positions-error-not-found') }} <a href="{{ route('positions.create') }}" class="alert-link">{{ _m('genre-positions-error-add') }}</a>
		</div>
	@endif
@endsection

@section('js')
	<script>
		vue = {
			data: {
				department: '',
				positions: {!! $positions !!},
				search: ''
			},

			computed: {
				filteredPositions () {
					let self = this
					let filteredPositions = this.positions.filter(function (position) {
						return position.department_id == self.department
					})

					return filteredPositions.filter(function (position) {
						let searchRegex = new RegExp(self.search, 'i')

						return searchRegex.test(position.name)
					})
				}
			},

			methods: {
				deletePosition (event) {
					let self = this

					$.confirm({
						title: "{{ _m('genre-positions-delete-title') }}",
						content: "{{ _m('genre-positions-delete-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									let position = $(event.target).closest('a').data('position')

									axios.delete('/admin/positions/' + position)
										.then(function (response) {
											let index = _.findIndex(self.positions, function (p) {
												return p.id == position
											})

											self.positions.splice(index, 1)

											flash(
												'{{ _m('genre-positions-flash-deleted-message') }}',
												'{{ _m('genre-positions-flash-deleted-title') }}'
											)
										})
								}
							},
							cancel: {
								text: "{{ _m('cancel') }}"
							}
						}
					})
				},

				toggleDisplay (event) {
					let index = _.findIndex(this.positions, function (p) {
						return p.id == $(event.srcEvent.target).parent().data('position')
					})

					if (index > -1) {
						this.positions[index].display = (event.value === true) ? 1 : 0
					}
				},

				updatePositions (event) {
					axios.patch("{{ route('positions.update') }}", {
						positions: this.positions
					}).then(function (response) {
						flash(
							'{{ _m('genre-positions-flash-updated-message') }}',
							'{{ _m('genre-positions-flash-updated-title') }}'
						)
					}).catch(function (error) {
						if (error.response.status == 422) {
							// Validation error
							flash(
								'{{ _m('genre-positions-flash-validation-message') }}',
								'{{ _m('genre-positions-flash-validation-title') }}',
								'danger'
							)
						}
					})
				}
			},

			mounted () {
				Sortable.create(document.getElementById('sortable'), {
					handle: '.sortable-handle',
					onEnd (event) {
						let order = new Array()

						$(event.from).children().each(function () {
							let id = $(this).data('id')

							if (id) {
								order.push(id)
							}
						})

						axios.patch('/admin/positions/reorder', {
							positions: order
						})
					}
				})
			}
		}
	</script>
@endsection