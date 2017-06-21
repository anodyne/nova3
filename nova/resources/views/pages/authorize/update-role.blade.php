@extends('layouts.app')

@section('title', _m('authorize-role-update'))

@section('content')
	<h1>{{ _m('authorize-role-update') }}</h1>

	{!! Form::model($role, ['route' => ['roles.update', $role], 'method' => 'put']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label sr-only">{{ _m('authorize-role-name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control']) !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<fieldset>
					<legend>{{ _m('authorize-permissions') }}</legend>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text"
									   class="form-control"
									   placeholder="{{ _m('authorize-permission-find') }}"
									   v-model="permissionSearch">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 mb-3" v-for="permission in filteredPermissions">
							<input type="checkbox" name="permissions[]" :value="permission.id" :checked="checked(permission.id)"> @{{ permission.name }}
						</div>
					</div>
				</fieldset>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('authorize-role-update') }}</button>
			<a href="{{ route('roles.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection

@section('js')
	<script>
		vue = {
			data: {
				permissions: {!! $permissions !!},
				permissionSearch: '',
				role: {!! $role !!}
			},

			computed: {
				filteredPermissions () {
					let self = this

					return self.permissions.filter(function (permission) {
						let searchRegex = new RegExp(self.permissionSearch, 'i')

						return searchRegex.test(permission.name) || searchRegex.test(permission.key)
					})
				}
			},

			methods: {
				checked (permission) {
					let search = _.find(this.role.permissions, function (p) {
						return p.id == permission
					})

					if (search) {
						return true
					}

					return false
				}
			}
		}
	</script>
@endsection