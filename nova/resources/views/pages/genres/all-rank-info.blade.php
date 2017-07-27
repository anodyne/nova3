@extends('layouts.app')

@section('title', _m('genre-rank-info'))

@section('content')
	<h1>{{ _m('genre-rank-info') }}</h1>

	@if ($info->count() > 0)
		<div class="data-table bordered striped" id="sortable">
			<div class="row header">
				<div class="col-8 col-md-5">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('genre-rank-info-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="search = ''">{!! icon('close') !!}</a>
						</span>
					</div>
				</div>
				<div class="col hidden-sm-down"></div>
				<div class="col col-xs-auto">
					<div class="btn-toolbar pull-right">
						@can('create', $rankInfoClass)
							<a href="{{ route('ranks.info.create') }}" class="btn btn-success">{!! icon('add') !!}</a>
						@endcan

						@can('update', $rankInfoClass)
							<a href="#"
							   class="btn btn-primary ml-2"
							   @click.prevent="updateInfo"
							   v-if="filteredInfo.length > 0">{!! icon('submit') !!}</a>
						@endcan

						@can('manage', $rankInfoClass)
							<div class="dropdown ml-2">
								<button type="button"
	  									class="btn btn-secondary btn-action"
	  									data-toggle="dropdown"
	  									aria-haspopup="true"
	  									aria-expanded="false">
									{!! icon('more') !!}
								</button>

								<div class="dropdown-menu dropdown-menu-right">
									<a href="{{ route('ranks.groups.index') }}" class="dropdown-item">{!! icon('list') !!} {{ _m('genre-rank-groups', [2]) }}</a>
									<a href="{{ route('ranks.items.index') }}" class="dropdown-item">{!! icon('star') !!} {{ _m('genre-ranks') }}</a>
								</div>
							</div>
						@endcan
					</div>
				</div>
			</div>
			<div class="row" v-if="filteredInfo.length == 0">
				<div class="col">
					<div class="alert alert-warning mb-0">
						{{ _m('genre-rank-info-error-not-found') }}
					</div>
				</div>
			</div>

			<div class="row align-items-start draggable-item"
				 :data-id="info.id"
				 v-for="(info, index) in filteredInfo">
				<div class="col col-auto">
					<span class="sortable-handle text-subtle">{!! icon('reorder') !!}</span>
				</div>
				<div class="col-9">
					<div class="row">
						<div class="col-md-6">
							<div :class="formGroupClasses('name', index)">
								<label class="form-control-label">{{ _m('name') }}</label>
								<input type="text" class="form-control" v-model="info.name">
							</div>
						</div>
						<div class="col-md-6">
							<div :class="formGroupClasses('short_name', index)">
								<label class="form-control-label">{{ _m('genre-rank-info-short_name') }}</label>
								<input type="text" class="form-control" v-model="info.short_name">
							</div>
						</div>
					</div>
				</div>
				<div class="col col-xs-auto">
					@can('delete', $rankInfoClass)
						<a class="btn btn-action btn-outline-danger pull-right" href="#" @click.prevent="deleteInfo(info.id)">{!! icon('delete') !!}</a>
					@endcan
				</div>
			</div>
		</div>
	@else
		<div class="alert alert-warning">
			{{ _m('genre-rank-info-error-not-found') }} <a href="{{ route('ranks.info.create') }}" class="alert-link">{{ _m('genre-rank-info-error-add') }}</a>
		</div>
	@endif

	<div class="alert alert-warning dirty d-flex align-items-center" v-if="dirtyInfo">
		{{ _m('genre-rank-info-unsaved') }} <a href="#" class="alert-btn" @click.prevent="updateInfo">{{ _m('save-now') }}</a>
	</div>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				hashOfInfo: '',
				hashOfInitialInfo: '',
				info: {!! $info !!},
				initialInfo: {!! $info !!},
				search: ''
			},

			computed: {
				dirtyInfo () {
					return this.hashOfInfo != this.hashOfInitialInfo
				},

				filteredInfo () {
					let self = this

					return this.info.filter(function (i) {
						let searchRegex = new RegExp(self.search, 'i')

						return searchRegex.test(i.name) || searchRegex.test(i.short_name)
					})
				}
			},

			methods: {
				deleteInfo (id) {
					let self = this

					$.confirm({
						title: "{{ _m('genre-rank-info-confirm-delete-title') }}",
						content: "{{ _m('genre-rank-info-confirm-delete-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									axios.delete(route('ranks.info.destroy', {info:id}))
										.then(function (response) {
											let index = _.findIndex(self.info, function (i) {
												return i.id == id
											})

											self.info.splice(index, 1)
											
											self.resetInitialHash()

											flash(
												'{{ _m('genre-rank-info-flash-deleted-message') }}',
												'{{ _m('genre-rank-info-flash-deleted-title') }}'
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

				formGroupClasses (field, index) {
					let classes = ['form-group', (this.info[index][field] == '' ? 'has-danger' : '')]

					return classes
				},

				resetInitialHash () {
					this.initialInfo = this.info
					this.hashOfInitialInfo = md5(JSON.stringify(this.initialInfo))
				},

				updateInfo () {
					axios.patch(route('ranks.info.update'), {
						info: this.info
					}).then(function (response) {
						flash(
							'{{ _m('genre-rank-info-flash-updated-message') }}',
							'{{ _m('genre-rank-info-flash-updated-title') }}'
						)
					}).catch(function (error) {
						if (error.response.status == 422) {
							// Validation error
							flash(
								'{{ _m('genre-rank-info-flash-validation-message') }}',
								'{{ _m('genre-rank-info-flash-validation-title') }}',
								'danger'
							)
						}
					})

					this.resetInitialHash()
				}
			},

			watch: {
				'info': {
					deep: true,
					handler (newValue, oldValue) {
						this.hashOfInfo = md5(JSON.stringify(this.info))
					}
				}
			},

			mounted () {
				// Hash the info
				this.hashOfInitialInfo = md5(JSON.stringify(this.initialInfo))
				this.hashOfInfo = md5(JSON.stringify(this.info))

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

						axios.patch(route('ranks.info.reorder'), {
							info: order
						})
					}
				})
			}
		}
	</script>
@endsection