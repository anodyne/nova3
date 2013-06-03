@if ($role->id == AccessRole::SYSADMIN)
	<div class="alert alert-block alert-danger">
		<h4>{{ lang('short.roles.duplicateSysAdminHeader') }}</h4>
		<p>{{ lang('short.roles.duplicateSysAdminText', lang('users')) }}</p>
	</div>
@endif
{{ Form::open(array('url' => 'admin/role')) }}
	<div class="control-group">
		<label class="control-label">{{ ucwords(langConcat('original role')) }}</label>
		<div class="controls">{{ $role->name }}</div>
	</div>

	<div class="control-group">
		<label class="control-label">{{ ucwords(langConcat('new name')) }}</label>
		<div class="controls">
			{{ Form::text('name', $role->name) }}
		</div>
	</div>

	<div class="controls">
		{{ Form::button(ucfirst(lang('action.submit')), array('type' => 'submit', 'class' => 'btn btn-primary')) }}
		
		{{ Form::token() }}
		{{ Form::hidden('id', $role->id) }}
		{{ Form::hidden('action', 'duplicate') }}
	</div>
{{ Form::close() }}