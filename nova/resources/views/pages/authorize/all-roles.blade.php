@extends('layouts.app')

@section('title', _m('authorize-roles'))

@section('content')
	<h1>{{ _m('authorize-roles') }}</h1>

	@if ($roles->count() > 0)
		<div class="data-table bordered striped">
			<div class="row header align-items-center">
				<div class="col-8">
					{{ _m('name') }}
				</div>
				<div class="col col-xs-auto">
					<div class="btn-toolbar pull-right">
						@can('create', $roleClass)
							<a href="{{ route('roles.create') }}" class="btn btn-success">{!! icon('add') !!}</a>
						@endcan

						@can('manage', $permissionClass)
							<div class="dropdown ml-2">
								<button type="button"
	  									class="btn btn-secondary btn-action"
	  									data-toggle="dropdown"
	  									aria-haspopup="true"
	  									aria-expanded="false">
									{!! icon('more') !!}
								</button>

								<div class="dropdown-menu dropdown-menu-right">
									@can('manage', $permissionClass)
										<a href="{{ route('permissions.index') }}" class="dropdown-item">{!! icon('lock') !!} {{ _m('authorize-permissions') }}</a>
									@endcan
								</div>
							</div>
						@endcan
					</div>
				</div>
			</div>

			<div class="row align-items-center" v-for="role in roles">
				<div class="col-9">
					@{{ role.name }}
				</div>
				<div class="col col-xs-auto">
					<div class="dropdown pull-right">
						<button class="btn btn-secondary btn-action"
								type="button"
								id="dropdownMenuButton"
								data-toggle="dropdown"
								aria-haspopup="true"
								aria-expanded="false">
							{!! icon('more') !!}
						</button>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
							@can('update', $roleClass)
								<a class="dropdown-item" :href="editLink(role.id)">
									{!! icon('edit') !!} {{ _m('edit') }}
								</a>
							@endcan

							@can('delete', $roleClass)
								<a class="dropdown-item text-danger" href="#" @click.prevent="deleteRole(role.id)">
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
			{{ _m('authorize-roles-error-not-found') }} <a href="{{ route('roles.create') }}" class="alert-link">{{ _m('authorize-roles-error-add') }}</a>
		</div>
	@endif
@endsection

@section('js')
	<script>
		vue = {
			data: {
				roles: {!! $roles !!}
			},

			methods: {
				deleteRole (id) {
					let self = this

					$.confirm({
						title: "{{ _m('authorize-roles-confirm-delete-title') }}",
						content: "{{ _m('authorize-roles-confirm-delete-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									axios.delete(route('roles.destroy', {role:id}))
										 .then(function (response) {
										 	let index = _.findIndex(self.roles, function (r) {
												return r.id == id
											})

											self.roles.splice(index, 1)

											flash(
												'{{ _m('authorize-roles-flash-deleted-message') }}',
												'{{ _m('authorize-roles-flash-deleted-title') }}'
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
					return route('roles.edit', {role:id})
				}
			}
		}
	</script>
@endsection