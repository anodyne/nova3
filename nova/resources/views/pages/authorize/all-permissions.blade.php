@extends('layouts.app')

@section('title', _m('authorize-permissions'))

@section('content')
	<h1>{{ _m('authorize-permissions') }}</h1>

	@if ($permissions->count() > 0)
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('permissions.create') }}" class="btn btn-success">{{ _m('authorize-permission-add') }}</a>
			</div>
			<div class="btn-group">
				<a href="{{ route('roles.index') }}" class="btn btn-secondary">{{ _m('authorize-roles') }}</a>
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
				@foreach ($permissions as $permission)
					<tr>
						<td>{{ $permission->name }}</td>
						<td>
							<div class="btn-toolbar">
								<div class="btn-group">
									<a href="{{ route('permissions.edit', [$permission]) }}" class="btn btn-sm btn-secondary">{{ _m('edit') }}</a>
								</div>
								<div class="btn-group">
									<a href="#" class="btn btn-sm btn-outline-danger" data-permission="{{ $permission->id }}" @click.prevent="deletePermission">{{ _m('delete') }}</a>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<div class="alert alert-warning">
			No permissions found. <a href="{{ route('permissions.create') }}" class="alert-link">Add a permission</a> now.
		</div>
	@endif
@endsection

@section('js')
	<script>
		vue = {
			methods: {
				deletePermission (event) {
					let confirm = window.confirm('Are you sure you want to delete this permission?');

					if (confirm) {
						let permission = event.target.getAttribute('data-permission');

						axios.delete('/admin/permissions/' + permission);

						window.location.replace('/admin/permissions');
					}
				}
			},
		};
	</script>
@endsection