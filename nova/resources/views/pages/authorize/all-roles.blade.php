@extends('layouts.app')

@section('title', _m('authorize-roles'))

@section('content')
	<h1>{{ _m('authorize-roles') }}</h1>

	<mobile>
		<div class="row">
			@can('create', $roleClass)
				<div class="col">
					<p><a href="{{ route('roles.create') }}" class="btn btn-success btn-block">{{ _m('authorize-role-add') }}</a></p>
				</div>
			@endcan

			@can('manage', $permissionClass)
				<div class="col">
					<p><a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-block">{{ _m('authorize-permissions') }}</a></p>
				</div>
			@endcan
		</div>
	</mobile>

	<desktop>
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
	</desktop>

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
									@can('update', $role)
										<a class="dropdown-item" href="{{ route('roles.edit', [$role]) }}">{!! icon('edit') !!} {{ _m('edit') }}</a>
									@endcan

									@can('delete', $role)
										<a class="dropdown-item text-danger" href="#" data-role="{{ $role->id }}" @click.prevent="deleteRole">{!! icon('delete') !!} {{ _m('delete') }}</a>
									@endcan
								</div>
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