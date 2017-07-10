@extends('layouts.app')

@section('title', _m('authorize-permissions'))

@section('content')
	<h1>{{ _m('authorize-permissions') }}</h1>

	<mobile>
		<div class="row">
			@can('create', $permissionClass)
				<div class="col">
					<p><a href="{{ route('permissions.create') }}" class="btn btn-success btn-block">{{ _m('authorize-permission-add') }}</a></p>
				</div>
			@endcan

			@can('manage', $roleClass)
				<div class="col">
					<p><a href="{{ route('roles.index') }}" class="btn btn-secondary btn-block">{{ _m('authorize-roles') }}</a></p>
				</div>
			@endcan
		</div>
	</mobile>

	<desktop>
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
	</desktop>

	@if ($permissions->count() > 0)
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('authorize-permission-find') }}" v-model="searchPermissions">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="searchPermissions = ''">{!! icon('close') !!}</a>
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
						<div class="dropdown pull-right">
							<button class="btn btn-secondary"
									type="button"
									id="dropdownMenuButton"
									data-toggle="dropdown"
									aria-haspopup="true"
									aria-expanded="false">
								{!! icon('more') !!}
							</button>
							<div class="dropdown-menu dropdown-menu-right"
								 aria-labelledby="dropdownMenuButton">
								@can('update', $permissionClass)
									<a :href="'/admin/permissions/' + permission.id + '/edit'" class="dropdown-item">{!! icon('edit') !!} {{ _m('edit') }}</a>
								@endcan

								@can('delete', $permissionClass)
									<a href="#" class="dropdown-item text-danger" :data-permission="permission.id" @click.prevent="deletePermission">{!! icon('delete') !!} {{ _m('delete') }}</a>
								@endcan
							</div>
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
					$.confirm({
						title: "{{ _m('authorize-permission-delete-title') }}",
						content: "{{ _m('authorize-permission-delete-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									let permission = event.target.getAttribute('data-permission')

									axios.delete('/admin/permissions/' + permission)

									window.setTimeout(() => {
										window.location.replace('/admin/permissions')
									}, 2000)
								}
							},
							cancel: {
								text: "{{ _m('cancel') }}"
							}
						}
					})
				}
			}
		}
	</script>
@endsection