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
					@can('create', $roleClass)
						<div class="btn-group pull-right">
							<a href="{{ route('roles.create') }}" class="btn btn-success">{!! icon('add') !!}</a>
  							<button type="button"
  									class="btn btn-success dropdown-toggle dropdown-toggle-split"
  									data-toggle="dropdown"
  									aria-haspopup="true"
  									aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
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

			@foreach ($roles as $role)
				<div class="row align-items-center">
					<div class="col-9">
						{{ $role->name }}
					</div>
					<div class="col col-xs-auto">
						<div class="dropdown pull-right">
							<button class="btn btn-secondary"
									type="button"
									id="dropdownMenuButton"
									data-toggle="dropdown"
									aria-haspopup="true"
									aria-expanded="false">
								{!! icon('more') !!}
							</button>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
								@can('update', $role)
									<a class="dropdown-item" href="{{ route('roles.edit', [$role]) }}">{!! icon('edit') !!} {{ _m('edit') }}</a>
								@endcan

								@can('delete', $role)
									<a class="dropdown-item text-danger" href="#" data-role="{{ $role->id }}" @click.prevent="deleteRole">{!! icon('delete') !!} {{ _m('delete') }}</a>
								@endcan
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
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
					$.confirm({
						title: "{{ _m('authorize-role-delete-title') }}",
						content: "{{ _m('authorize-role-delete-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									let role = event.target.getAttribute('data-role')

									axios.delete('/admin/roles/' + role)

									window.setTimeout(() => {
										window.location.replace('/admin/roles')
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