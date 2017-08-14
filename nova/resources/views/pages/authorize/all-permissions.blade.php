@extends('layouts.app')

@section('title', _m('authorize-permissions'))

@section('content')
	<h1>{{ _m('authorize-permissions') }}</h1>

	@if ($permissions->count() > 0)
		<div class="data-table bordered striped">
			<div class="row header">
				<div class="col">
					<mobile>
						<a href="#"
						   class="btn btn-secondary btn-action"
						   v-show="!mobileSearch"
						   @click.prevent="mobileSearch = true">{!! icon('search') !!}</a>

						<div class="input-group" v-show="mobileSearch">
							<input type="text" class="form-control" placeholder="{{ _m('authorize-permissions-find') }}" v-model="search">
							<span class="input-group-btn">
								<a class="btn btn-secondary"
								   href="#"
								   @click.prevent="resetSearch">{!! icon('close') !!}</a>
							</span>
						</div>
					</mobile>
					<desktop>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="{{ _m('authorize-permissions-find') }}" v-model="search">
							<span class="input-group-btn">
								<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">{!! icon('close') !!}</a>
							</span>
						</div>
					</desktop>
				</div>
				<div class="col d-none d-lg-block"></div>
				<div class="col col-auto" v-show="!mobileSearch">
					<div class="btn-toolbar">
						@can('create', $permissionClass)
							<a href="{{ route('permissions.create') }}" class="btn btn-success">{!! icon('add') !!}</a>
						@endcan

						@can('manage', $roleClass)
							<div class="dropdown ml-2">
								<button type="button"
	  									class="btn btn-secondary btn-action"
	  									data-toggle="dropdown"
	  									aria-haspopup="true"
	  									aria-expanded="false">
									{!! icon('more') !!}
								</button>

								<div class="dropdown-menu dropdown-menu-right">
									@can('manage', $roleClass)
										<a href="{{ route('roles.index') }}" class="dropdown-item">{!! icon('lock') !!} {{ _m('authorize-roles') }}</a>
									@endcan
								</div>
							</div>
						@endcan
					</div>
				</div>
			</div>

			<div class="row align-items-center" v-for="permission in filteredPermissions">
				<div class="col">
					@{{ permission.name }}
				</div>
				<div class="col col-auto">
					<div class="dropdown">
						<button class="btn btn-secondary btn-action"
								type="button"
								id="dropdownMenuButton"
								data-toggle="dropdown"
								aria-haspopup="true"
								aria-expanded="false">
							{!! icon('more') !!}
						</button>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
							@can('update', $permissionClass)
								<a :href="editLink(permission.id)" class="dropdown-item">
									{!! icon('edit') !!} {{ _m('edit') }}
								</a>
							@endcan

							@can('delete', $permissionClass)
								<a href="#" class="dropdown-item text-danger" @click.prevent="deletePermission(permission.id)">
									{!! icon('delete') !!} {{ _m('delete') }}
								</a>
							@endcan
						</div>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="alert alert-warning">
			{{ _m('authorize-permissions-error-not-found') }} <a href="{{ route('permissions.create') }}" class="alert-link">{{ _m('authorize-permissions-error-add') }}</a>
		</div>
	@endif
@endsection

@section('js')
	<script>
		vue = {
			data: {
				mobileSearch: false,
				permissions: {!! $permissions !!},
				search: ''
			},

			computed: {
				filteredPermissions () {
					let self = this

					return self.permissions.filter(function (permission) {
						let searchRegex = new RegExp(self.search, 'i')

						return searchRegex.test(permission.name) || searchRegex.test(permission.key)
					})
				}
			},

			methods: {
				deletePermission (id) {
					let self = this

					$.confirm({
						title: "{{ _m('authorize-permissions-confirm-delete-title') }}",
						content: "{{ _m('authorize-permissions-confirm-delete-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									axios.delete(route('permissions.destroy', {permission:id}))
										 .then(function (response) {
										 	let index = _.findIndex(self.permissions, function (p) {
												return p.id == id
											})

											self.permissions.splice(index, 1)

											flash(
												'{{ _m('authorize-permissions-flash-deleted-message') }}',
												'{{ _m('authorize-permissions-flash-deleted-title') }}'
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

				editLink (id) {
					return route('permissions.edit', {permission:id})
				},

				resetSearch () {
					this.search = ''
					this.mobileSearch = false
				}
			}
		}
	</script>
@endsection