@extends('layouts.app')

@section('title', 'Roles')

@section('content')
	<h1>Roles</h1>

	@if ($roles->count() > 0)
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('roles.create') }}" class="btn btn-success">{{ _m('authorize-role-add') }}</a>
			</div>
			<div class="btn-group">
				<a href="{{ route('permissions.index') }}" class="btn btn-secondary">{{ _m('authorize-permissions') }}</a>
			</div>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($roles as $role)
					<tr>
						<td>{{ $role->name }}</td>
						<td>
							<div class="btn-toolbar">
								<div class="btn-group">
									<a href="{{ route('roles.edit', [$role]) }}" class="btn btn-sm btn-secondary">{{ _m('edit') }}</a>
								</div>
								<div class="btn-group">
									<a href="#" class="btn btn-sm btn-outline-danger" data-role="{{ $role->id }}" @click.prevent="deleteRole">{{ _m('delete') }}</a>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<div class="alert alert-warning">
			No roles found. <a href="{{ route('roles.create') }}" class="alert-link">Add a role</a> now.
		</div>
	@endif
@endsection

@section('js')
	<script>
		vue = {
			methods: {
				deleteRole (event) {
					let confirm = window.confirm('Are you sure you want to delete this role?');

					if (confirm) {
						let role = event.target.getAttribute('data-role');

						axios.delete('/admin/roles/' + role);

						window.location.replace('/admin/roles');
					}
				}
			},
		};
	</script>
@endsection