@extends('layouts.app')

@section('title', _m('authorize-role-add'))

@section('content')
	<h1>{{ _m('authorize-role-add') }}</h1>

	{!! Form::open(['route' => 'roles.store']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
					<label class="form-control-label sr-only">{{ _m('authorize-role-name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' form-control-danger' : ''), 'placeholder' => _m('authorize-role-name')]) !!}
					{!! $errors->first('name', '<p class="form-control-feedback">:message</p>') !!}
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
									   v-model="searchPermissions">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 mb-3" v-for="permission in filteredPermissions">
							<input type="checkbox" name="permissions[]" :value="permission.id" :checked="isChecked(permission.id)">
							@{{ permission.name }}
						</div>
					</div>
				</fieldset>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('authorize-role-add') }}</button>
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
				searchPermissions: ''
			},

			computed: {
				filteredPermissions () {
					let self = this

					return this.permissions.filter(function (permission) {
						let regex = new RegExp(self.searchPermissions, 'i')

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