@extends('layouts.app')

@section('title', _m('genre-positions', [2]))

@section('content')
	<h1>{{ _m('genre-positions', [2]) }}</h1>

	@if ($positions->count() > 0)
		<div class="data-table bordered striped" id="sortable">
			<div class="row header">
				<div class="col-12 col-md-5">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('genre-positions-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="search = ''">{!! icon('close') !!}</a>
						</span>
					</div>
					<div class="mt-2 hidden-md-up">
						{!! Form::departments(null, $departments, null, ['v-model' => 'department', 'placeholder' => _m('genre-depts-select')]) !!}
					</div>
				</div>
				<div class="col hidden-sm-down">
					{!! Form::departments(null, $departments, null, ['v-model' => 'department', 'placeholder' => _m('genre-depts-select')]) !!}
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
							   @click.prevent="updatePositions">{!! icon('check') !!}</a>
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
			<div class="row align-items-start draggable-item"
				 :data-id="position.id"
				 v-if="department != '' && filteredPositions.length > 0"
				 v-for="position in filteredPositions">
				<desktop>
					<div class="col col-auto">
						<span class="sortable-handle text-subtle">{!! icon('reorder') !!}</span>
					</div>
				</desktop>
				<div class="col">
					<div class="row">
						<div class="col-md-6">
							<div :class="formGroupClasses('name', position.id)">
								<label class="form-control-label">{{ _m('name') }}</label>
								<input type="text" class="form-control" v-model=position.name>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">{{ _m('genre-depts', [1]) }}</label>
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
								<textarea class="form-control" rows="5" v-model="position.description"></textarea>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-control-label">{{ _m('genre-positions-available') }}</label>
								<input type="number" class="form-control" min="0" v-model="position.available">
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
				<div class="col col-auto">
					@can('delete', $positionClass)
						<a href="#"
						   class="btn btn-outline-danger btn-action mb-4"
						   @click.prevent="deletePosition(position.id)">{!! icon('delete') !!}</a>
					@endcan

					<mobile>
						<div class="btn btn-block btn-outline-secondary sortable-handle">{!! icon('reorder') !!}</div>
					</mobile>
				</div>
			</div>
		</div>
	@else
		<div class="alert alert-warning">
			{{ _m('genre-positions-error-not-found') }} <a href="{{ route('positions.create') }}" class="alert-link">{{ _m('genre-positions-error-add') }}</a>
		</div>
	@endif

	<div class="alert alert-warning dirty" v-if="dirtyPositions">
		<span>{{ _m('genre-positions-unsaved') }}</span>
		<a href="#" class="alert-btn" @click.prevent="updatePositions">{{ _m('save-now') }}</a>
	</div>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				department: '',
				hashOfInitialPositions: '',
				hashOfPositions: '',
				initialPositions: {!! $positions !!},
				positions: {!! $positions !!},
				search: ''
			},

			computed: {
				dirtyPositions () {
					return this.hashOfPositions != this.hashOfInitialPositions
				},

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
				deletePosition (id) {
					let self = this

					$.confirm({
						title: "{{ _m('genre-positions-confirm-delete-title') }}",
						content: "{{ _m('genre-positions-confirm-delete-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									axios.delete(route('positions.destroy', {position:id}))
										 .then(function (response) {
										 	let index = _.findIndex(self.positions, function (p) {
												return p.id == id
											})

											self.positions.splice(index, 1)

											self.resetInitialHash()

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

				formGroupClasses (field, id) {
					let index = _.findIndex(this.positions, function (p) {
						return p.id == id
					})

					let classes = ['form-group', (this.positions[index][field] == '' ? 'has-danger' : '')]

					return classes
				},

				resetInitialHash () {
					this.initialPositions = this.positions
					this.hashOfInitialPositions = md5(JSON.stringify(this.initialPositions))
				},

				toggleDisplay (event) {
					let index = _.findIndex(this.positions, function (p) {
						return p.id == $(event.srcEvent.target).parent().data('position')
					})

					if (index > -1) {
						this.positions[index].display = (event.value === true) ? 1 : 0
					}
				},

				updatePositions () {
					axios.patch(route('positions.update'), {
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

					this.resetInitialHash()
				}
			},

			watch: {
				'positions': {
					handler (newValue, oldValue) {
						this.hashOfPositions = md5(JSON.stringify(this.positions))
					},
					deep: true
				}
			},

			mounted () {
				// Hash the position objects
				this.hashOfInitialPositions = md5(JSON.stringify(this.initialPositions))
				this.hashOfPositions = md5(JSON.stringify(this.positions))

				Sortable.create(document.getElementById('sortable'), {
					draggable: '.draggable-item',
					handle: '.sortable-handle',
					onEnd (event) {
						let order = new Array()

						$(event.from).children().each(function () {
							let id = $(this).data('id')

							if (id) {
								order.push(id)
							}
						})

						axios.patch(route('positions.reorder'), {
							positions: order
						})
					}
				})
			}
		}
	</script>
@endsection