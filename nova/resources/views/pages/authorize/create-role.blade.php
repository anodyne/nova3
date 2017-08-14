@extends('layouts.app')

@section('title', _m('authorize-roles-add'))

@section('content')
	<h1>{{ _m('authorize-roles-add') }}</h1>

	{!! Form::open(['route' => 'roles.store']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label">{{ _m('name') }}</label>
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
			<button type="submit" class="btn btn-primary">{{ _m('authorize-roles-add') }}</button>
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
				search: ''
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
					let result = _.findIndex(this.oldPermissions, function (p) {
						return p == permission
					})

					return (result >= 0)
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