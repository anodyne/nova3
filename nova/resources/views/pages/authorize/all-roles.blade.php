@extends('layouts.app')

@section('title', _m('authorize-roles'))

@section('content')
	<h1>{{ _m('authorize-roles') }}</h1>

	<div class="btn-toolbar">
		@can('create', $roleClass)
			<div class="btn-group">
				<a href="{{ route('roles.create') }}" class="btn btn-success">{{ _m('authorize-role-add') }}</a>
			</div>
		@endcan

		@can('manage', $permissionClass)
			<div class="btn-group">
				<a href="{{ route('permissions.index') }}" class="btn btn-secondary">{{ _m('authorize-permissions') }}</a>
			</div>
		@endcan
	</div>

	@if ($roles->count() > 0)
		<table class="table">
			<thead class="thead-default">
				<tr>
					<th colspan="2">{{ _m('name') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($roles as $role)
					<tr>
						<td>{{ $role->name }}</td>
						<td>
							<div class="btn-toolbar">
								@can('update', $role)
									<div class="btn-group">
										<a href="{{ route('roles.edit', [$role]) }}" class="btn btn-sm btn-secondary">{{ _m('edit') }}</a>
									</div>
								@endcan

								@can('delete', $role)
									<div class="btn-group">
										<a href="#" class="btn btn-sm btn-outline-danger" data-role="{{ $role->id }}" @click.prevent="deleteRole">{{ _m('delete') }}</a>
									</div>
								@endcan
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<div class="alert alert-warning">
			{{ _m('authorize-role-error-not-found') }} <a href="{{ route('roles.create') }}" class="alert-link">{{ _m('authorize-role-error-add') }}</a>
		</div>
	@endif
@endsection

@section('js')
	<script>
		vue = {
			methods: {
				deleteRole (event) {
					let confirm = window.confirm("{{ _m('authorize-role-delete') }}")

					if (confirm) {
						let role = event.target.getAttribute('data-role')

						axios.delete('/admin/roles/' + role)

						window.location.replace('/admin/roles')
					}
				}
			}
		}
	</script>
@endsection