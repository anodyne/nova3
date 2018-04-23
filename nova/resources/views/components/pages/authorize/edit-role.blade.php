<h1>{{ _m('authorize-roles-update') }}</h1>

{!! Form::model($role, ['route' => ['roles.update', $role], 'method' => 'patch']) !!}
	<div class="row">
		<div class="col md:col-4">
			<text-input label="{{ _m('name') }}"
						name="name"
						value="{{ $role->name }}"
						error="{{ $errors->first('name') }}">
			</text-input>
		</div>
	</div>

	<div class="row">
		<div class="col md:col-8">
			<fieldset>
				<legend>{{ _m('authorize-permissions') }}</legend>

				<div class="row">
					<div class="col md:col-6">
						<text-input placeholder="{{ _m('authorize-permissions-find') }}" v-model="search">
							<template slot="field-addon-before">
								<icon name="search" />
							</template>
						</text-input>
					</div>
				</div>

				<div class="row">
					<div class="col md:col-4 mb-3" v-for="permission in filteredPermissions">
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

	<div class="submit-controls">
		<button type="submit" class="button is-primary">{{ _m('authorize-roles-update') }}</button>
		<a href="{{ route('roles.index') }}" class="button is-secondary">{{ _m('cancel') }}</a>
	</div>
{!! Form::close() !!}