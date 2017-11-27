@extends('layouts.app')

@section('title', _m('authorize-roles-update'))

@section('content')
	<h1>{{ _m('authorize-roles-update') }}</h1>

	{!! Form::model($role, ['route' => ['roles.update', $role], 'method' => 'patch']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>{{ _m('name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : '')]) !!}
					{!! $errors->first('name', '<p class="invalid-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<fieldset>
					<legend>{{ _m('authorize-permissions') }}</legend>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group input-group">
								<span class="input-group-addon">
									{!! icon('search') !!}
								</span>
								<input type="text"
									   class="form-control"
									   placeholder="{{ _m('authorize-permissions-find') }}"
									   v-model="search">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 mb-3" v-for="permission in filteredPermissions">
							<label class="custom-control custom-checkbox">
								<input type="checkbox"
									   name="permissions[]"
									   class="custom-control-input"
									   :value="permission.id"
									   :checked="isChecked(permission.id)">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">@{{ permission.name }}</span>
							</label>
						</div>
					</div>
				</fieldset>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('authorize-roles-update') }}</button>
			<a href="{{ route('roles.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection

@section('js')
	<script>
		vue = {
			data: {
				permissions: {!! $permissions !!},
				oldPermissions: [],
				search: '',
				role: {!! $role !!}
			},

			computed: {
				filteredPermissions () {
					let self = this

					return this.permissions.filter(function (permission) {
						let regex = new RegExp(self.search, 'i')

						return regex.test(permission.name) || regex.test(permission.key)
					})
				}
			},

			methods: {
				isChecked (permission) {
					let searchRole = _.find(this.role.permissions, function (p) {
						return p.id == permission
					})

					let searchOld = _.findIndex(this.oldPermissions, function (p) {
						return p == permission
					})

					if (searchRole || searchOld >= 0) {
						return true
					}

					return false
				}
			},

			mounted () {
				@if (old('permissions'))
					this.oldPermissions = {!! json_encode(old('permissions')) !!}
				@endif
			}
		}
	</script>
@endsection