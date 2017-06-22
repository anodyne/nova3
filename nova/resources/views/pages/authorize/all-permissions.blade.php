@extends('layouts.app')

@section('title', _m('authorize-permissions'))

@section('content')
	<h1>{{ _m('authorize-permissions') }}</h1>

	<div class="btn-toolbar">
		@can('create', $permissionClass)
			<div class="btn-group">
				<a href="{{ route('permissions.create') }}" class="btn btn-success">{{ _m('authorize-permission-add') }}</a>
			</div>
		@endcan

		@can('manage', $roleClass)
			<div class="btn-group">
				<a href="{{ route('roles.index') }}" class="btn btn-secondary">{{ _m('authorize-roles') }}</a>
			</div>
		@endcan
	</div>

	@if ($permissions->count() > 0)
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('authorize-permission-find') }}" v-model="searchPermissions">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="searchPermissions = ''"><i class="fa fa-fw fa-close"></i></a>
						</span>
					</div>
				</div>
			</div>
		</div>

		<table class="table">
			<thead class="thead-default">
				<tr>
					<th colspan="2">{{ _m('name') }}</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="permission in filteredPermissions">
					<td>@{{ permission.name }}</td>
					<td>
						<div class="btn-toolbar">
							@can('update', $permissionClass)
								<div class="btn-group">
									<a :href="'/admin/permissions/' + permission.id + '/edit'" class="btn btn-sm btn-secondary">{{ _m('edit') }}</a>
								</div>
							@endcan

							@can('delete', $permissionClass)
								<div class="btn-group">
									<a href="#" class="btn btn-sm btn-outline-danger" :data-permission="permission.id" @click.prevent="deletePermission">{{ _m('delete') }}</a>
								</div>
							@endcan
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	@else
		<div class="alert alert-warning">
			{{ _m('authorize-permission-error-not-found') }} <a href="{{ route('permissions.create') }}" class="alert-link">{{ _m('authorize-permission-error-add') }}</a>
		</div>
	@endif
@endsection

@section('js')
	<script>
		vue = {
			data: {
				permissions: {!! $permissions !!},
				searchPermissions: ''
			},

			computed: {
				filteredPermissions () {
					let self = this

					return self.permissions.filter(function (permission) {
						let searchRegex = new RegExp(self.searchPermissions, 'i')

						return searchRegex.test(permission.name) || searchRegex.test(permission.key)
					})
				}
			},

			methods: {
				deletePermission (event) {
					let confirm = window.confirm("{{ _m('authorize-permission-delete') }}")

					if (confirm) {
						let permission = event.target.getAttribute('data-permission')

						axios.delete('/admin/permissions/' + permission)

						window.location.replace('/admin/permissions')
					}
				}
			}
		}
	</script>
@endsection