@extends('layouts.app')

@section('title', _m('genre-rank-groups', [2]))

@section('content')
	<h1>{{ _m('genre-rank-groups', [2]) }}</h1>

	@if ($rankGroups->count() > 0)
		<div class="data-table bordered striped" id="sortable">
			<div class="row header">
				<div class="col-12 col-md-5">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('genre-rank-groups-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="search = ''">{!! icon('close') !!}</a>
						</span>
					</div>
				</div>
				<div class="col hidden-sm-down"></div>
				<div class="col col-md-auto">
					<div class="btn-toolbar pull-right">
						@can('create', $rankGroupClass)
							<a href="{{ route('ranks.groups.create') }}" class="btn btn-success">{!! icon('add') !!}</a>
						@endcan

						@can('update', $rankGroupClass)
							<a href="#"
							   class="btn btn-primary ml-2"
							   @click.prevent="updateGroups">{!! icon('check') !!}</a>
						@endcan

						@can('manage', $rankGroupClass)
							<div class="dropdown ml-2">
								<button type="button"
	  									class="btn btn-secondary btn-action"
	  									data-toggle="dropdown"
	  									aria-haspopup="true"
	  									aria-expanded="false">
									{!! icon('more') !!}
								</button>

								<div class="dropdown-menu dropdown-menu-right">
									<a href="{{ route('ranks.info.index') }}" class="dropdown-item">{!! icon('info') !!} {{ _m('genre-rank-info') }}</a>
									<a href="{{ route('ranks.items.index') }}" class="dropdown-item">{!! icon('star') !!} {{ _m('genre-ranks', [2]) }}</a>
								</div>
							</div>
						@endcan
					</div>
				</div>
			</div>

			<div class="row align-items-start draggable-item"
				 :data-id="group.id"
				 v-for="(group, index) in filteredGroups">
				<desktop>
					<div class="col col-auto">
						<span class="sortable-handle text-subtle">{!! icon('reorder') !!}</span>
					</div>
				</desktop>
				<div class="col">
					<div class="row">
						<div class="col-md-6">
							<div :class="formGroupClasses('name', index)">
								<label class="form-control-label">{{ _m('name') }}</label>
								<input type="text" class="form-control" v-model="group.name">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">{{ _m('displayed') }}</label>
								<div>
									<toggle-button class="toggle-switch lg"
												   :value="group.display == 1"
												   :data-group="group.id"
												   @change="toggleDisplay"></toggle-button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col col-auto">
					<div class="dropdown">
						<button class="btn btn-secondary btn-action mb-4"
								type="button"
								id="dropdownMenuButton"
								data-toggle="dropdown"
								aria-haspopup="true"
								aria-expanded="false">
							{!! icon('more') !!}
						</button>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
							@can('create', $rankGroupClass)
								<a class="dropdown-item" href="#" @click.prevent="duplicateGroup(group.id)">
									{!! icon('copy') !!} {{ _m('duplicate') }}
								</a>
							@endcan

							@can('delete', $rankGroupClass)
								<a class="dropdown-item text-danger" href="#" @click.prevent="deleteGroup(group.id)">
									{!! icon('delete') !!} {{ _m('delete') }}
								</a>
							@endcan
						</div>

						<mobile>
							<div class="btn btn-block btn-secondary sortable-handle">{!! icon('reorder') !!}</div>
						</mobile>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="alert alert-warning">
			{{ _m('genre-rank-groups-error-not-found') }} <a href="{{ route('ranks.groups.create') }}" class="alert-link">{{ _m('genre-rank-groups-error-add') }}</a>
		</div>
	@endif

	<div class="alert alert-warning dirty d-flex align-items-center" v-if="dirtyGroups">
		{{ _m('genre-rank-groups-unsaved') }} <a href="#" class="alert-btn" @click.prevent="updateGroups">{{ _m('save-now') }}</a>
	</div>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				groups: {!! $rankGroups !!},
				hashOfInitialGroups: '',
				hashOfGroups: '',
				initialGroups: {!! $rankGroups !!},
				search: ''
			},

			computed: {
				dirtyGroups () {
					return this.hashOfGroups != this.hashOfInitialGroups
				},

				filteredGroups () {
					let self = this

					return this.groups.filter(function (group) {
						let searchRegex = new RegExp(self.search, 'i')

						return searchRegex.test(group.name)
					})
				}
			},

			methods: {
				deleteGroup (id) {
					let self = this

					$.confirm({
						title: "{{ _m('genre-rank-groups-confirm-delete-title') }}",
						content: "{{ _m('genre-rank-groups-confirm-delete-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									axios.delete(route('ranks.groups.destroy', {group:id}))
										.then(function (response) {
											let index = _.findIndex(self.groups, function (g) {
												return g.id == id
											})

											self.groups.splice(index, 1)

											self.resetInitialHash()

											flash(
												'{{ _m('genre-rank-groups-flash-deleted-message') }}',
												'{{ _m('genre-rank-groups-flash-deleted-title') }}'
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

				duplicateGroup (id) {
					$.confirm({
						title: "{{ _m('genre-rank-groups-confirm-duplicate-title') }}",
						columnClass: "medium",
						content: "URL:" + route('ranks.groups.duplicate-confirm') + "?group=" + id,
						theme: "dark",
						buttons: {
							formSubmit: {
								text: "{{ _m('duplicate') }}",
								btnClass: "btn-success",
								action () {
									$('#duplicateForm').submit()
								}
							},
							cancel: {
								text: "{{ _m('cancel') }}"
							}
						}
					})
				},

				formGroupClasses (field, index) {
					let classes = ['form-group', (this.groups[index][field] == '' ? 'has-danger' : '')]

					return classes
				},

				resetInitialHash () {
					this.initialGroups = this.groups
					this.hashOfInitialGroups = md5(JSON.stringify(this.initialGroups))
				},

				toggleDisplay (event) {
					let index = _.findIndex(this.groups, function (g) {
						return g.id == $(event.srcEvent.target).parent().data('group')
					})

					if (index > -1) {
						this.groups[index].display = (event.value === true) ? 1 : 0
					}
				},

				updateGroups () {
					axios.patch(route('ranks.groups.update'), {
						groups: this.groups
					}).then(function (response) {
						flash(
							'{{ _m('genre-rank-groups-flash-updated-message') }}',
							'{{ _m('genre-rank-groups-flash-updated-title') }}'
						)
					}).catch(function (error) {
						if (error.response.status == 422) {
							// Validation error
							flash(
								'{{ _m('genre-rank-groups-flash-validation-message') }}',
								'{{ _m('genre-rank-groups-flash-validation-title') }}',
								'danger'
							)
						}
					})

					this.resetInitialHash()
				}
			},

			watch: {
				'groups': {
					deep: true,
					handler (newValue, oldValue) {
						this.hashOfGroups = md5(JSON.stringify(this.groups))
					}
				}
			},

			mounted () {
				// Hash the groups
				this.hashOfInitialGroups = md5(JSON.stringify(this.initialGroups))
				this.hashOfGroups = md5(JSON.stringify(this.groups))

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

						axios.patch(route('ranks.groups.reorder'), {
							groups: order
						})
					}
				})
			}
		}
	</script>
@endsection